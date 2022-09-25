<?php

class Db_class{

     public function db_connect()
    {
        try {
          $servername = "localhost";
          $database = "whatsapp";
          $username = "root";
          $password = "";
          
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
            return $conn;
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }

  
}









?>