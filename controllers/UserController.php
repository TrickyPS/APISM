<?php

include("../models/User.php");
include("../db/Connection.php");
header('Content-Type: application/json');


if (isset($_SERVER['REQUEST_METHOD']))
{
  switch ($_SERVER['REQUEST_METHOD'])
  {
    
      case 'POST':
        try {
          $json = file_get_contents('php://input');
          $data = json_decode($json);
          $nombre = $data->nombre;
          $apellido = $data->apellido;
          $email = $data->email;
          $password = $data->password;
          
          if($nombre && $apellido && $email && $password ){
            $resp = User::Save($nombre,$apellido,$email,$password);
            if( $resp  != false ){
              http_response_code(200);
              echo json_encode($resp);
            }else{
              echo $resp;
              http_response_code(500);
              echo json_encode(array("message"=>"Internal Error"));
            }
          }else{
            http_response_code(400);
            echo json_encode(array("message"=>"Bad Request"));
          }
        } catch (Exception $th) {
          http_response_code(500);
          echo json_encode(array("message"=>"Internal Error"));
        }
        break;

      case 'PUT':
        try {
          $image = null;
          $id = null;

          $json = file_get_contents('php://input');
          $data = json_decode($json);
          if(isset($data->image))
          $image = $data->image;
      
      
          if(isset($_GET["id"]))
            $id= $_GET["id"];

           if($image && $id ){
            $resp = User::Update($id,$image);

            if( $resp  != false ){
              http_response_code(200);
              echo json_encode($resp);
            }else{
              
              http_response_code(500);
              echo json_encode(array("message"=>"Internal Error"));
            }
            }else{
              http_response_code(400);
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