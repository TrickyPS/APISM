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
       } catch (\Throwable $th) {
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
          while($row = $query->fetch_assoc()) {

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
      } catch (\Throwable $th) {
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
    } catch (\Throwable $th) {
        return false;
    }
    Connection::disconnect($db);
 }

}

?>