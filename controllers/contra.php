<?php

include("../models/User.php");
include("../db/Connection.php");
header('Content-Type: application/json');


if (isset($_SERVER['REQUEST_METHOD']))
{
  switch ($_SERVER['REQUEST_METHOD'])
  {

      case 'PUT':
        try {
          $contraseña = null;
          $contraseña2 = null;
          $id = null;
          
          $json = file_get_contents('php://input');
          $data = json_decode($json);
          if(isset($_GET["id"]))
            $id= $_GET["id"];

            if(isset($data->contrasena) && isset($data->nuevacontra)){
              $contraseña = $data->contrasena;
              $contraseña2 = $data->nuevacontra;

              $resp = User::Contra($id,$contraseña,$contraseña2);


           if( $resp  != false ){
            http_response_code(200);
            echo json_encode(array("estatus"=>true));
          }else{
            
            http_response_code(500);
            echo json_encode(array("message"=>"Internal Error"));
          }
            }
            else{
                http_response_code(500);
                echo json_encode(array("message"=>"Bad Request"));
            }
        } catch (Exception $th) {
          http_response_code(500);
          echo json_encode(array("message"=>"Internal Error"));
        }
        break;

      default :
      http_response_code(404);
      echo json_encode(array("message"=>"Resource Not Found "));
  }
}



?>