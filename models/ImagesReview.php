<?php


class ImagesReview {


    public static function Save($id_review,$image){
       try {
        $db = Connection::connect();
        $query = $db->query("CALL SP_SaveImagesReview('".$image."',".$id_review.")");
        if($query){
          Connection::disconnect($db);
            $review = $query->fetch_assoc();
            return true; 
          }
          else{
            $error = $db->error;
            Connection::disconnect($db);
            return $error;
          }
        return true;
       } catch (\Throwable $th) {
           return false;
       }
       Connection::disconnect($db);
    }

    public static function GetImagesByIdReview($id_review){
      try {
       $db = Connection::connect();
       $query = $db->query("SELECT * FROM images WHERE id_review = ".$id_review." ORDER BY id DESC;");
       if($query){
         Connection::disconnect($db);
         $images = null;
         while($row = $query->fetch_assoc()) {

           $images[]=$row;
   
         }
          return $images; 
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