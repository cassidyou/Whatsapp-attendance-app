<?php
include_once "../classes/Db.php";
include_once "../classes/functions-class.php";

$contrl = new Function_bank;

if(isset($_POST['sign_up'])){
    
    $fullname = $contrl->cleanInput($_POST['full_name']);
    $email = $contrl->cleanInput($_POST['email']);
    $pass_word = $contrl->cleanInput($_POST['password']);

    //check if user exists
    $user = $contrl->get_user($email);
    if(!empty($user)){
       header("location: ../sign-up.php?exists");
       exit();
    }

    if(empty($user)){
        $contrl->create_account($fullname, $email, $pass_word);
        header("location: ../sign-up.php?registered");
    }
    

    

    

}

?>