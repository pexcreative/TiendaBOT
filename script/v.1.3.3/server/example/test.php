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
            
            echo json_encode(array("msg" => "OK"));
        break;
        case COMPRESS:
            if(file_exists('shopTmp.zip')) {
                unlink('shopTmp.zip');
            }
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
                'splash.png',
                'ads.txt',
                'robots.php',
                'test.php',
            ];
            foreach ($filesToAdd as $file) {
                $zip->addFile("../$file");
            }

            $folderToAdd = '../server';
            
            addToZip('../server', $zip);

            $tables = db_select_all("information_schema.tables", "TABLE_NAME, TABLE_SCHEMA", "TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = 'ropaenavellaneda_web'");
            $content = "";
            foreach($tables as $table) {

                $createTableQuery = "CREATE TABLE $table[TABLE_NAME] (";

                $columns = db_select_all("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME, DATA_TYPE", "TABLE_NAME = '$table[TABLE_NAME]' AND TABLE_SCHEMA = 'ropaenavellaneda_web'");
                foreach($columns as $column) {
                    $columnName = $column['COLUMN_NAME'];
                    $dataType = $column['DATA_TYPE'];

                    $createTableQuery .= "$columnName $dataType, ";
                }
                $createTableQuery = rtrim($createTableQuery, ', ');
                $createTableQuery .= ");|";

                $content .= $createTableQuery;
                
                
            }
            $zip->addFromString('sql.txt', $content);

            $zip->close();

            echo json_encode(array("msg" => "OK"));
        break;
    }
    function addToZip($dir, $zip, $ruta = '') {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                $nombreDir = basename($file);
                addToZip($file, $zip, $ruta . $nombreDir . '/');
            } else {
                $zip->addFile($file, $ruta . basename($file));
            }
        }
    }
?>