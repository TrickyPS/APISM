<?php

include("../models/ImagesReview.php");
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
          $id_review = $data->id_review;
          $image = $data->image;
          
          if($id_review && $image ){
            $resp = ImagesReview::Save($id_review,$image);
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
        } catch (\Throwable $th) {
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