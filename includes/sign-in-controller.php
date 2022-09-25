<?php
include_once "../classes/Db.php";
include_once "../classes/functions-class.php";

$contrl = new Function_bank;

if(isset($_POST["sign_in"])){
    $email = $contrl->cleanInput($_POST['email']);
    $password = $contrl->cleanInput($_POST['password']);

      //check if user exists
      $user = $contrl->get_user($email);
      if(!empty($user)){
        
        $current_password = $user['psd'];
        $check_pwd = password_verify($password, $current_password);

        if($check_pwd == true){
            session_start();
            $_SESSION["id"] = $user["id"];
            $_SESSION["fullname"] = $user["name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["created_at"] = $user["created_at"];

            header("location: ../index.php");
        }else{
            header("location: ../sign-in.php?incorrect");
        }
      }else{
        header("location: ../sign-in.php?incorrect");
      }

     
}

?>