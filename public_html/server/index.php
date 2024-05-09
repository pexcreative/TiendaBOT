<?php
    require_once '../classes/DatabasePDOInstance.function.php';
    
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('max_execution_time', '0');
    date_default_timezone_set("America/Mexico_City");
    
    @session_start();

    $infoRequest = $_REQUEST;

    $db = DatabasePDOInstance();
    
	$op = isset($_REQUEST["o"]) ? $_REQUEST["o"] : false;

    define("INGRESAR", 1);
    define("EDITAR_ITEM", 2);
    define("EDITAR_CAT", 3);
    define("LOGOUT", 4);
    define("KEET", 5);
    define("DONWLOAD", 6);
    define("COMPRESS", 7);

    $key = "P3xN3w";
 
    switch(intval($op)) {
        case INGRESAR:
            $msg = "Error, datos incorrectos.";
            
            $_REQUEST["p"] = md5($key.$_REQUEST["p"].$key);
            $info = db_select_row("users", "*", "user = '$_REQUEST[e]' AND password = '$_REQUEST[p]' ");
            if($info) {
                $_SESSION["P3xN3w"]["info"] = $info;
                $msg = "OK";
            }
            echo json_encode(array("msg" => $msg));
        break;
        case EDITAR_ITEM:
            $info = db_select_row("items", "*", "product = '$_REQUEST[i]'");
            if($info) {
                db_update("items", array(
                    "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                    "price" => isset($_REQUEST["p"]) && $_REQUEST["p"] != "" ? $_REQUEST["p"] : null,
                    "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                    "alternative" => isset($_REQUEST["alt"]) && $_REQUEST["alt"] != "" ? $_REQUEST["alt"] : null,
                    "date" => date("Y-m-d H:i:s")
                ), "product = '".$_REQUEST["i"]."'");
            }
            else {
                db_insert("items", array(
                    "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                    "price" => isset($_REQUEST["p"]) && $_REQUEST["p"] != "" ? $_REQUEST["p"] : null,
                    "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                    "alternative" => isset($_REQUEST["alt"]) && $_REQUEST["alt"] != "" ? $_REQUEST["alt"] : null,
                    "date" => date("Y-m-d H:i:s"),
                    "product" => $_REQUEST["i"]
                ));
            }
            echo json_encode(array("msg" => "OK"));
        break;
        case EDITAR_CAT:
            if($_REQUEST["s"] > 0) {
                $info = db_select_row("keywords", "*", "keyword = '$_REQUEST[i]'");
                if($info) {
                    db_update("keywords", array(
                        "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                        "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                        "date" => date("Y-m-d H:i:s")
                    ), "keyword = '".$_REQUEST["i"]."'");
                }
                else {
                    db_insert("keywords", array(
                        "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                        "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                        "keyword" => isset($_REQUEST["i"]) && $_REQUEST["i"] != "" ? $_REQUEST["i"] : null,
                        "date" => date("Y-m-d H:i:s")
                    ));
                }
            }
            else {
                $info = db_select_row("categories", "*", "category = '$_REQUEST[i]'");
                if($info) {
                    db_update("categories", array(
                        "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                        "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null
                    ), "category = '".$_REQUEST["i"]."'");
                }
                else {
                    db_insert("categories", array(
                        "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                        "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                        "category" => $_REQUEST["i"]
                    ));
                }
            }
            echo json_encode(array("msg" => "OK"));
        break;
        case LOGOUT:
            unset($_SESSION["P3xN3w"]);
            unset($_SESSION);
            echo json_encode(array("msg" => "OK"));
        break;
        case KEET:
            echo json_encode(array("msg" => "OK"));
        break;
        case DONWLOAD:

            if(file_exists('shopTmp.zip')) {
                unlink('shopTmp.zip');
            }
        
            $createFile = @file_get_contents("https://ropaenavellaneda.com.ar/server/?o=7");
                    
            file_put_contents("shopTmp.zip", @file_get_contents("https://ropaenavellaneda.com.ar/server/shopTmp.zip"));
        
            $zip = new ZipArchive;
        
            if ($zip->open("shopTmp.zip") === true) {
                $zip->extractTo("../");
                $zip->close();
        
                $extractedFiles = scandir("../");
        
                /*foreach ($extractedFiles as $file) {
                    echo "$file<br>";
                    /*if ($file != '.' && $file != '..') {
                        if(is_dir($file)) {
                            getFilesAndFolder($file);
                        }
                        else {
                            setFile("$file");
                        }
                    }* /
                }*/
        
                $infoTable = array();
                $tables = db_select_all("information_schema.tables", "TABLE_NAME, TABLE_SCHEMA", "TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = '$dbName'");
                foreach($tables as $table) {
                    $infoTable[$table["TABLE_NAME"]] = db_select_all($table["TABLE_NAME"], "*", "");
                }
        
                if(file_exists("../sql.txt")) {
                    $infoFile = @file_get_contents("../sql.txt");
                    if($infoFile) {
                        $queries = explode("|", $infoFile);
                        //echo "<br>";
                        $db->query("drop database $dbName");
                        $db->query("create database $dbName");
                        $db->query("use $dbName");

                        $db = DatabasePDOInstance();

                        foreach($queries as $q) {
                            //echo "1 -> $q<br>"; 
                            if($q != "") {
                                $db->query($q);
                            }
                        }
                    }
                    unlink("../sql.txt");
                }
        
                foreach($infoTable as $t => $data) {
                        
                    foreach($data as $d) {
                        $columns = implode(', ', array_keys($d));
        
                        $values = "('" . implode("', '", $d) . "')";
        
                        $q = "INSERT INTO $t ($columns) VALUES $values;";
                        //echo $q."<br>";
                        $db->query($q);
                    }
        
                }
        
                //echo "OK";
        
            }
            
            echo json_encode(array("msg" => "OK"));
        break;
        case COMPRESS:

            if(file_exists('shopTmp.zip')) {
                unlink('shopTmp.zip');
            }

            file_put_contents('../version.txt', "$shopVersion");

            $zip = new ZipArchive();
            $zipFilename = 'shopTmp.zip';

            if ($zip->open($zipFilename, ZipArchive::CREATE) !== true) {
                die('Error al crear el archivo ZIP');
            }

            $filesToAdd = [
                'footer.php',
                'head.php',
                'categoria.php',
                'item.php',
                'index.php',
                'categorias.php',
                'login.php',
                'sw.js',
                'consultar.php',
                'ficha-producto.php',
                'denuncia.php',
                'contacto.php',
                'convertImageTmp.php',
                'removefiles.php',
                'traduccion.php',
                'icon.png',
                'version.txt',
                'comprar.php'
            ];
            foreach ($filesToAdd as $file) {
                
                $fileToInclude = realpath("../$file");
                
                $zip->addFile($fileToInclude, basename($fileToInclude));
            }

            $folderToAdd = '../server';

            $zip->addEmptyDir("server");
            
            addToZip('../server', $zip);

            //addFolderToZip($zip, '../' . '/server');

            $tables = db_select_all("information_schema.tables", "TABLE_NAME, TABLE_SCHEMA", "TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = 'ropaenavellaneda_web'");
            $content = "";
            foreach($tables as $table) {

                $createTableQuery = "CREATE TABLE $table[TABLE_NAME] (";

                $columns = db_select_all("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME, DATA_TYPE, COLUMN_TYPE", "TABLE_NAME = '$table[TABLE_NAME]' AND TABLE_SCHEMA = 'ropaenavellaneda_web'");
                foreach($columns as $column) {
                    $columnName = $column['COLUMN_NAME'];
                    $dataType = $column['COLUMN_TYPE'];

                    $createTableQuery .= "$columnName $dataType ".($columnName != "id" ? " DEFAULT NULL" : " NOT NULL AUTO_INCREMENT").", ";
                }
                $createTableQuery = rtrim($createTableQuery, ', ');
                $createTableQuery .= ", PRIMARY KEY (`id`) );|";

                $content .= $createTableQuery;
                
            }
            $zip->addFromString('sql.txt', $content);

            $zip->close();

            echo json_encode(array("msg" => "OK"));
        break;
    }

    function getFilesAndFolder($folder) {
        foreach(scandir($folder) as $f) {
            if(is_dir($f)) {
                getFilesAndFolder($f);
            }
            else {
                setFile("$folder/$f");
            }
        }
    }

    function setFile($file) {
        if (file_exists($file)) {
            unlink($file);
        }
        
        rename($file, $file);
    }

    /*function addFolderToZip($zip, $folderPath) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
    
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
    
                $zip->addFile($filePath, $relativePath);
            }
        }
    }*/

    function addFolderToZip($zip, $folderPath) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
    
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
    
                // Cambio en esta línea: eliminar el nombre de la carpeta principal
                $zip->addFile($filePath, 'server/' . $relativePath);
            }
        }
    }

    function addToZip($dir, $zip, $ruta = '') {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                $nombreDir = basename($file);
                addToZip($file, $zip, $ruta . $nombreDir . '/');
            } else {
                $zip->addFile($file, "server/$ruta" . basename($file));
            }
        }
        /*$files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
    
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($dir) + 1);
    
                $zip->addFile($filePath, $relativePath);
            }
        }*/
    }
?>