<?php


class Review {


    public static function Save($titulo,$subtitulo,$contenido,$id_user){
       try {
        $db = Connection::connect();
        $query = $db->query("CALL SP_SaveReview('".$titulo."','".$subtitulo."','".$contenido."',".$id_user.")");
        
        if($query){
          Connection::disconnect($db);
            $review = $query->fetch_assoc();
            return $review; 
          }
          else{
            echo $db->error;
            Connection::disconnect($db);
            return false;
          }
        return true;
       } catch (Exception $th) {
           return false;
       }
       Connection::disconnect($db);
    }

    public static function GetAllPreviews(){
      try {
       $db = Connection::connect();
       $query = $db->query("CALL SP_GetAllPreview()");
       if($query){
         Connection::disconnect($db);
          $reviews= null;
          while($row = mysqli_fetch_assoc($query)) {
           $reviews[]=$row;
    
          }
          
           return $reviews;
         }
         else{
           echo $db->error;
           Connection::disconnect($db);
           return false;
         }
       return true;
      } catch (Exception $th) {
          return false;
      }
      Connection::disconnect($db);
   }
  
   public static function GetReviewById($id_review,$id){
    try {
     $db = Connection::connect();
     $query = $db->query("CALL SP_GetReviewById(".$id_review.",".$id.")");
     
     if($query){
       Connection::disconnect($db);
         $review = $query->fetch_assoc();
         return $review; 
       }
       else{
         echo $db->error;
         Connection::disconnect($db);
         return false;
       }
     return true;
    } catch (Exception $th) {
        return false;
    }
    Connection::disconnect($db);
 }

 public static function GetAllPreviewCreatedByUser($id_user){
  try {
   $db = Connection::connect();
   $query = $db->query("CALL SP_GetAllPreviewCreatedByUser(".$id_user.")");
   
   if($query){
      Connection::disconnect($db);
       $reviews= null;
       while($row = mysqli_fetch_assoc($query)) {
        $reviews[]=$row;
 
       }
       
        return $reviews;
      }
     else{
       echo $db->error;
       Connection::disconnect($db);
       return false;
     }
   return true;
  } catch (Exception $th) {
      return false;
  }
  Connection::disconnect($db);
}

public static function GetSearch(){
  try {
   $db = Connection::connect();
   $query = $db->query("CALL SP_Buscar()");
   if($query){
     Connection::disconnect($db);
      $reviews= null;
      while($row = mysqli_fetch_assoc($query)) {
       $reviews[]=$row;

      }
       return $reviews;
     }
     else{
       echo $db->error;
       Connection::disconnect($db);
       return false;
     }
  } catch (Exception $th) {
      return false;
  }
  Connection::disconnect($db);
}

public static function BorrarReview($idReview){
  try{
    $db = Connection::connect();
    $query = $db->query("CALL SP_BorrarReview(".$idReview.");");
    if($query){
      Connection::disconnect($db);
      return true;
    }else{
      echo $db->error;
      Connection::disconnect($db);
      return false;
    } 
  } catch (exception $th){
    return false;
  }
  Connection::disconnect($db);
}

public static function ActualizarReview($idReview, $titulo, $subtitulo, $contenido){
  try{
    $db = Connection::connect();
    $query = $db->query("CALL SP_ActualizarReview(".$idReview.",'".$titulo."','".$subtitulo."','".$contenido."');");

    if($query){
      Connection::disconnect($db);
      $review = $query->fetch_assoc();
      return $review;
    }else{
      echo $db->error;
      Connection::disconnect($db);
      return false;
    }
  } catch (Exception $th){
    return false;
  }
}

}

?>