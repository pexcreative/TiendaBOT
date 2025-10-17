<?php
    if(!isset($dbServer)) {
        if(file_exists("../config.php")) {
            require_once "../config.php";
        }
        else if(file_exists("config.php")) {
            require_once "config.php";
        }
    }
	require_once("DatabasePDO.class.php");

    function in_arr($needle, $arr) {
        $band = false;
        if($arr) {
            foreach($arr as $a) {
                if(strstr($a, $needle)) {
                    $band = true;
                    break;
                }
            }
        }
        return $band;
    }
	
	function db_select_all($table, $columns, $strQueryCondition = "1",  $where = true, $print = false) {
        $db = $GLOBALS["db"];
        $sqlQuery = "SELECT $columns FROM $table ".($strQueryCondition != "" && $strQueryCondition != "1" ? ($where ? " WHERE " : "")."$strQueryCondition" : "");
        if($print) {
            echo $sqlQuery; die();
        }
        //
        return $db->getAll($sqlQuery);
    }

    function db_select_one($table, $columns, $strQueryCondition = "1",  $where = true, $print = false) {
        $db = $GLOBALS["db"];
        $sqlQuery = "SELECT $columns FROM $table ".($strQueryCondition != "" && $strQueryCondition != "1" ? ($where ? " WHERE " : "")."$strQueryCondition" : "");
        if($print) {
            echo $sqlQuery; die();
        }
        return $db->getOne($sqlQuery);
    }

    function db_select_row($table, $columns, $strQueryCondition = "1",  $where = true, $print = false) {
        $db = $GLOBALS["db"];
        $sqlQuery = "SELECT $columns FROM $table".($strQueryCondition != "" && $strQueryCondition != "1" ? ($where ? " WHERE " : "")."$strQueryCondition" : "");
        if($print) {
            echo $sqlQuery; die();
        }
        return $db->getRow($sqlQuery);
    }

    function db_insert($table, $values, $echo = false) {
        $db = $GLOBALS["db"];
        $cols = array_keys($values);
        $items = array_values($values);
        $db->query("
            INSERT INTO $table 
                (" . implode(", ", $cols) . ")
            VALUES
                (" . implode(", ", array_map(function($v) {
                    return "?";
                }, $cols)) . ")
        ", $items);
        if($echo) {
            echo "
            INSERT INTO $table 
                (" . implode(", ", $cols) . ")
            VALUES
                (" . implode(", ", array_map(function($v) {
                    return "?";
                }, $cols)) . ")
        ";
        }
        return $db->getInsertID();
    }

    function db_update($table, $values, $strQueryCondition = "", $echo = false) {
        $db = $GLOBALS["db"];
        $cols = array_keys($values);
        $items = array_values($values);
        $arr = array();
        foreach($cols as $k => $col) {
            $arr[] = "$col = ".($items[$k] == null ? "NULL" : "'" . $items[$k] . "'");
        }
        $strQuery = implode(", ", $arr);    
        $sqlQuery = "UPDATE $table SET $strQuery WHERE $strQueryCondition";
        if($echo) {
            echo "$sqlQuery<br>";
        }
        return $db->query($sqlQuery);
    }

    function db_delete($table, $strQueryCondition = "") {
        $db = $GLOBALS["db"];
        return $db->query("DELETE FROM $table WHERE $strQueryCondition");
    }
	
	function DatabasePDOInstance() {		
		$servername = $GLOBALS["dbServer"];
		$username 	= $GLOBALS["dbUsername"];		
		$password = $GLOBALS["dbPassword"];
		$database 	= $GLOBALS["dbName"];
		return new DatabasePDO($servername, $username, $password, $database);
	}
?>