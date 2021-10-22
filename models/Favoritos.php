<?php


class Favoritos {


    public static function Save($id_review,$id_user,$check){
       try {
        $db = Connection::connect();
        $query = $db->query("REPLACE INTO favoritos(id_user,id_review,`check`) VALUES (".$id_user.",".$id_review.",'".$check."');");
        if($query){
          Connection::disconnect($db);
            return true; 
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

   
    public static function GetAllPreviewByUser($id_user){
        try {
         $db = Connection::connect();
         $query = $db->query("CALL SP_GetAllPreviewByUser(".$id_user.")");
         
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
    
    

}
