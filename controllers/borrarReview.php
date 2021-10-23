<?php

include("../models/User.php");
include("../db/Connection.php");
header('Content-Type: application/json');

if (isset($_SERVER['REQUEST_METHOD']))
{
    switch($_SERVER['REQUEST_METHOD']){
        case 'DELETE':
            try{
                if(isset($_GET['idReview'])){
                    $idReview = $_GET['idReview'];
                }
                if($idReview){
                    $resp = Review::BorrarReview($idReview)
                    if($resp){
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
            }catch (Exception $th){
                http_response_code(500);
                echo json_encode(array("message"=>"Internal Error"));
            }
            break;

        case 'POST':
            try{
                $json = file_get_contents('php://input');
                $data = json_decode($json);

                $idReview = $data->idReview;
                $titulo = $data->titulo;
                $subtitulo = $data->subtitulo;
                $contenido = $data->contenido;

                if($idReview && $titulo && $subtitulo && $contenido){
                    $resp = Review::ActualizarReview($idReview, $titulo, $subtitulo, $contenido);
                    if($resp){
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
            } catch (Exception $th){
                http_response_code(500);
                echo json_encode(array("message"=>"Internal Error"));
            }
        default :
        http_response_code(404);
        echo json_encode(array("message"=>"Resource Not Found "));
    }
}
?>