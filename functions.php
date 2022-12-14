<?php
include_once "../Db.php";
    //DATABASE CONNECTION 
    function db_connect(){
        try {
        $servername = "localhost";
        $database = "whatsapp_attendance";
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

    $conn = db_connect();

       //CLEAN THE INPUT DATA
       function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

    // OPEN THE FILE IN READ MODE
    $input = fopen("text_files/exported.txt", "r");
  

    //RETURN MEMBERS IN THE GROUP
    function get_group_members($input_file){

        $members = [];

        while(!feof($input_file)) {
  
            // Display each line
            $string = fgets($input_file);
    
            // $str = 'before-str-after';
            if (preg_match('/ - (.*?):/', $string, $matches) == 1) {
                // echo  $date[1]."-----". $matches[1] . "<br>";
          
                $members[] = $matches[1];
            }   
        }
        return $members;  
    }

    print_r(get_group_members($input));
    exit();

   


    
    //RETURN FULL DETAILS OF THE COMMENTS BY USERS
    function get_comment_details($input_file){
        $details = [];

        while(!feof($input_file)) {
  
            // Display each line
            $string = fgets($input_file);
    
            // $str = 'before-str-after';
            if (preg_match('/ - (.*?):/', $string, $matches) == 1) {
                // echo  $date[1]."-----". $matches[1] . "<br>";
          
                // $members[] = $matches[1];
                $details[] = $string;
            }   
        }
        return $details;
       
    }




    //RETURN USER ATTENDANCE
    function get_users_attendance($input_file){
        $comments = get_comment_details($input_file);

        $user_attendance = [];
        foreach($comments as $comment){

            
    
            if (preg_match('/(.*?,)(.*?-)(.*?:)/', $comment, $matches) == 1) {
                $user_attendance[] = $matches;
            }
        }
        return $user_attendance;
    }


    //REGISTER MEMBERS
    function register_group_members($input_file){
        global $conn;
        $group_members = get_group_members($input_file);
        foreach($group_members as $member){
            $member = cleanInput($member);

            $stmt = $conn->prepare("SELECT id FROM users WHERE full_name = ?");
            $stmt->execute([$member]);

            if(!$stmt->rowCount()){
                $sql = $conn->prepare("INSERT INTO users (full_name, role) VALUES (?, ?)");
                $sql->execute([$member, "Member"]);
            }
        

        }
    }


    function get_member_id($full_name){
        global $conn;
      
        $stmt = $conn->prepare("SELECT users.id FROM users WHERE full_name = ?");
        $stmt->execute([$full_name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }


    //REGISTER USER ATTENDANCE
    function register_attendance($input_file){
        global $conn;

        $attendace_list = get_users_attendance($input_file);

        
                //ERASE ALL THE DATA IN THE ATTENDANCE TABLE (To avoid duplicate record)
                //The file contains all the comments from the day the group was created
                $sql = $conn->prepare("DELETE FROM attendance");
                $sql->execute();
                

        foreach($attendace_list as $user_attendance){
            $user_name =  cleanInput(substr($user_attendance[3],0, - 1)); // removes : at the end of the name;
             $str_date =  cleanInput(substr($user_attendance[1],0, - 1)); //remove the , at the end of the date string and the date like 2/7/22 (this format cannot be inserted to db)

            $meeting_date = preg_replace('/\//', '-', $str_date); //returns the date like 2-7-22 (this format can be inserted to db)
            
            $dt = \DateTime::createFromFormat('m/d/y', $str_date);
            $meeting_date = $dt->format('y-m-d');

            
            // fetching the id of each user_name
            $stmt = $conn->prepare("SELECT id FROM users WHERE full_name = ?;");
            $stmt->execute([$user_name]);

            if($stmt->rowCount() > 0){

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $user_id = $result["id"];

                // insert the id and date of comment to the attendance table
                $sql = $conn->prepare("INSERT INTO attendance (users_id, meeting_date)  VALUES (?, ?)");
                $sql->execute([$user_id, $meeting_date]); 
                
            }

        }
    }

   

    

    $input = fopen("exported.txt", "r");
    // register_attendance($input);
 
?>