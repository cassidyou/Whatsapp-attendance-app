<?php
include_once "../config.php";
include_once "../classes/Db.php";
include_once "../classes/functions-class.php";


$contrl = new Function_bank;
//CREATE NEW GROUP
if(isset($_POST["add_group"])){
    $group_name = $contrl->cleanInput($_POST["group_name"]);
    $user_id = $_SESSION["id"];

    if($contrl->group_exists($user_id, $group_name) == true){
        header("Location: ../create-group.php?exists");
    }else{
        $contrl->create_group($user_id, $group_name);
        header("Location: ../create-group.php?created");
    }
    
}


$upload = new Function_bank;
if(isset($_POST['upload'])){
    $group_id = $_POST["group_id"];
    $admin_id = $_POST["admin_id"];


    $input_file = $_FILES['input_file'];
    $result = $upload->upload_file($input_file);
    if($result =="unsupported"){
        header("Location: ../upload-chat.php?unsupported");
    }elseif($result == "wrong"){
        header("Location: ../upload-chat.php?wrong");
    }elseif($result == "no file"){
        header("Location: ../upload-chat.php?no-file");
    }else{
        $input = fopen($result, "r");
        $group_members = $upload->get_group_members($input);
        $upload->register_members($group_members,$admin_id);
        $upload->register_member_group($group_id, $group_members);

        $input = fopen($result, "r");
        $upload->register_attendance($input, $group_id);
    header("Location: ../upload-chat.php?good"); 

    }

    
}



?>