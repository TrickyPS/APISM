<?php


class ImagesReview {


    public static function Save($id_review,$image){
       try {
        $db = Connection::connect();
        $query = $db->query("CALL SP_SaveImagesReview('".$image."',".$id_review.")");
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