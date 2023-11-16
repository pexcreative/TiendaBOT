<?php
    require_once '../classes/DatabasePDOInstance.function.php';
    
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('max_execution_time', '0');
    date_default_timezone_set("America/Mexico_City");
    
    session_start();

    $infoRequest = $_REQUEST;

    $db = DatabasePDOInstance();
    
	$op = isset($_REQUEST["o"]) ? $_REQUEST["o"] : false;

    define("INGRESAR", 1);
    define("EDITAR_ITEM", 2);
    define("EDITAR_CAT", 3);
    define("LOGOUT", 4);

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
                    "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null
                ), "product = '".$_REQUEST["i"]."'");
            }
            else {
                db_insert("items", array(
                    "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                    "price" => isset($_REQUEST["p"]) && $_REQUEST["p"] != "" ? $_REQUEST["p"] : null,
                    "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
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
                    ), "keyword = '".$_REQUEST["i"]."'");
                }
                else {
                    db_insert("keywords", array(
                        "title" => isset($_REQUEST["t"]) && $_REQUEST["t"] != "" ? $_REQUEST["t"] : null,
                        "description" => isset($_REQUEST["d"]) && $_REQUEST["d"] != "" ? $_REQUEST["d"] : null,
                        "keyword" => isset($_REQUEST["i"]) && $_REQUEST["i"] != "" ? $_REQUEST["i"] : null
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
    }
?>