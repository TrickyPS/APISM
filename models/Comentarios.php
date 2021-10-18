<?php


class Comentarios {


    public static function Save($id_review,$id_user,$comment){
       try {
        $db = Connection::connect();
        $query = $db->query("INSERT INTO comentarios(id_user,id_review,comment) VALUES (".$id_user.",".$id_review.",'".$comment."');");
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
       } catch (\Throwable $th) {
           return false;
       }
       Connection::disconnect($db);
    }

    public static function GetAllComments($id_review){
      try {
       $db = Connection::connect();
       $query = $db->query("CALL SP_GetComentarios(".$id_review.")");
       if($query){
         Connection::disconnect($db);
         $comentarios = null;
         while($row = $query->fetch_assoc()) {

           $comentarios[]=$row;
   
         }
          return $comentarios; 
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
