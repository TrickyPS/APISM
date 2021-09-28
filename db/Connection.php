<?php


class Connection{

     public static function  connect() {
            $settings  = require_once ("../config.php");
            $dbHost = $settings["dbHost"];
            $dbName = $settings["dbName"];
            $dbUser = $settings["dbUser"];
            $dbPass = $settings["dbPass"];
            
            $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            if ($mysqli->connect_errno) {
                echo "Problema con la conexion a la base de datos";
            }
            return $mysqli;
        }
  
    


        public static function disconnect($mysqli) {
            mysqli_close($mysqli);
        }
    
    
    
    
    }
    
?>