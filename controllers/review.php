<?php

include("../models/Review.php");
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
          $titulo = $data->titulo;
          $subtitulo = $data->subtitulo;
          $contenido = $data->contenido;
          
          if($id_user && $titulo && $subtitulo && $contenido ){
            $resp = Review::Save($titulo,$subtitulo,$contenido,$id_user);
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

        case 'GET':
          try {
            $id_review = null;
            $id_user=null;
            $id = null;
            $resp = null;
              if(isset($_GET['id_review']) && isset($_GET['id']) ){
                  $id = $_GET['id'];
                  $id_review = $_GET['id_review'];
                  $resp = Review::GetReviewById($id_review,$id);
              }else if(isset($_GET["id_user"])){
                $id_user = $_GET["id_user"];
                $resp = Review::GetAllPreviewCreatedByUser($id_user);
              }else{
                $resp = Review::GetAllPreviews();
              }
              
              if( $resp  != false ){
                http_response_code(200);
                echo json_encode($resp, JSON_PRETTY_PRINT);
              }else{
                echo $resp;
                http_response_code(500);
                echo json_encode(array("message"=>"Internal Error"));
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