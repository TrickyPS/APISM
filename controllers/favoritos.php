<?php

include("../models/Favoritos.php");
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
          $id_user = $data->id_user;
          $id_review = $data->id_review;
          $check= $data->check;
          if($id_review && $id_user  ){
            $resp = Favoritos::Save($id_review,$id_user,$check);
            if( $resp  != false ){
              http_response_code(200);
              echo json_encode(array("estatus"=>true));
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

        case 'GET':
        try {
          
          $id_user = null;
          if(isset($_GET["id_user"]))
            $id_user = $_GET["id_user"];
          if( $id_user  ){
            $resp = Favoritos::GetAllPreviewByUser($id_user);
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

      default :
      http_response_code(404);
      echo json_encode(array("message"=>"Resource Not Found "));
  }
}

