<?php


class Votos {


    public static function Save($id_review,$id_user,$is_voted){
       try {
        $db = Connection::connect();
        $query = $db->query("REPLACE INTO votosreview(id_user,id_review,voto) VALUES (".$id_user.",".$id_review.",'".$is_voted."');");
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

   
  

}
