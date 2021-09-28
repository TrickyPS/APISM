<?php


class User {


    public static function Save($nombre,$apellido,$email,$password){
       try {
        $result = null;
        $db = Connection::connect();
        $query = $db->query("CALL SP_AddUser('".$nombre."','".$apellido."','".$email."','".$password."')");
        
        if($query){
          Connection::disconnect($db);
            $user = $query->fetch_assoc();
            return $user; 
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


    public static  function Auth($email,$pass){
        try {
            $user = null;
            $db = Connection::connect();
            $query = $db->query("CALL SP_FindUserByAuth('".$email."','".$pass."')");
            
            if($query){
              Connection::disconnect($db);
                $user = $query->fetch_assoc();
               // $user["avatar"] = base64_encode($user["avatar"]);
                return $user; 
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

    public static function Update($id,$image){
      try { 
        $result = null;
        $db = Connection::connect();
         $db->query("UPDATE `user` SET `image` ='". $image ."' WHERE `id` =" .$id );
         $query = $db->query("SELECT * FROM `user` WHERE `id` = ".$id);
        if($query){
          Connection::disconnect($db);
            $user = $query->fetch_assoc();
            //$user["avatar"] = base64_encode($user["avatar"]);
            return $user; 
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