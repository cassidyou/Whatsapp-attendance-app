<?php 
include_once "Db.php";
class Function_bank extends Db_class {
    
    //CLEAN AND ESCAPE SPECIAL CHARACTERS 
    public function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //ADD NEW GROUP
    public function create_group($user_id, $group_name){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("INSERT INTO groups (users_id, name) 
                VALUES (?, ?);");
        $stmt->execute([$user_id, $group_name]);
    }

    //CHECK IF GROUP EXISTS
    public function group_exists($user_id, $group_name){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT id FROM groups WHERE users_id = ? AND name = ?");
        $stmt->execute([$user_id, $group_name]);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    //CHECKING FOR EXISTING USER
    public function get_user($email){
        $conn = $this->db_connect();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        }
    }

    //USER REGISTRATION
    public function create_account($fullname, $email, $password){
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $conn = $this->db_connect();
        $stmt = $conn->prepare("INSERT INTO users (name, email, psd) VALUES (?, ?, ?);");
        $stmt->execute([$fullname, $email, $pwd]);
    }

    // EXTRACT ALL THE GROUP MEMBERS IN THE TEXT FILE
    public function get_group_members($text_file){
        
        $members = [];

        while(!feof($text_file)) {
            $string = fgets($text_file);

            if (preg_match('/ - (.*?):/', $string, $matches) == 1) {
                $members[] = $this->cleanInput($matches[1]);
            }   
        }
        return $members; 
    }

    //INSERT MEMBERS EXTRACTED FROM THE TEXT FILE TO THE MEMBERS TABLE
    public function register_members($group_members, $user_id){
        
        foreach($group_members as $member){
            $conn = $this->db_connect();
            $member = $this->cleanInput($member);

            $stmt = $conn->prepare("SELECT id FROM members WHERE users_id = ? AND name = ?");
            $stmt->execute([$user_id, $member]);

            if($stmt->rowCount() == 0){
                $sql = $conn->prepare("INSERT INTO members (users_id, name) VALUES (?, ?);");
                $sql->execute([$user_id, $member]);
            }
        }
    }

    //GET MEMBER_ID FROM THE MEMBERS TABLE
    public function get_member_id($fullname){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT id FROM members WHERE name = ?");
        $stmt->execute([$fullname]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }

    //INSERT MEMBERS TO THE MEMBER_GROUP TABLE
    public function register_member_group($group_id, $group_members){
        foreach($group_members as $member){
            $member_id = $this->get_member_id($member);
            $conn = $this->db_connect();
            $stmt = $conn->prepare("SELECT id FROM member_group WHERE member_id = ? AND group_id = ?");
            $stmt->execute([$member_id, $group_id]);

            if($stmt->rowCount() == 0){
                $sql = $conn->prepare("INSERT INTO member_group (member_id, group_id) VALUES (?, ?)");
                $sql->execute([$member_id, $group_id]);
            }
        }
    }

    // RETURN ALL COMMENTS INFO (DATE, TIME, MEMBER AND THE COMMENT TEXT)
     public function get_comment_info($text_file){
        $comment_info = [];

        while(!feof($text_file)) {
            $string = fgets($text_file);

            if (preg_match('/ - (.*?):/', $string, $matches) == 1) {
                $comment_info[] = $string;
            }   
        }
        return $comment_info;
    }

    // EXTRACT COMMENT INFO (USER AND DATE)
    public function get_member_and_date($text_file){
        $comments = $this->get_comment_info($text_file);

        $result = [];
        foreach($comments as $comment){

            if (preg_match('/(.*?,)(.*?-)(.*?:)/', $comment, $matches) == 1) {
                $result[] = $matches;
            }
        }
        return $result;
    }


    //REGISTER MEMBERS ATTENDANCE
    public function register_attendance($text_file, $group_id){
        $conn = $this->db_connect();
        $attendace_list = $this->get_member_and_date($text_file);

        //Erase this groups attendance (to avoid duplicate information) since the text file contains all the comments from the day the group was created 
        $sql = $conn->prepare("DELETE FROM attendance WHERE group_id = ?");  
        $sql->execute([$group_id]);    

        foreach($attendace_list as $user_attendance){
            $fullname =  $this->cleanInput(substr($user_attendance[3],0, - 1)); // removes : at the end of the name;
            $str_date =  $this->cleanInput(substr($user_attendance[1],0, - 1)); //remove the , at the end of the date string and the date like 2/7/22 (this format cannot be inserted to db)
            $member_id = $this->get_member_id($fullname);

            $meeting_date = preg_replace('/\//', '-', $str_date); //returns the date like 2-7-22 (this format can be inserted to db)
            
            $dt = \DateTime::createFromFormat('m/d/y', $str_date);
            $meeting_date = $dt->format('y-m-d');


            $stmt = $conn->prepare("INSERT INTO attendance (member_id, group_id, member_role, meeting_date)  VALUES (?, ?, ?, ?)");
            $stmt->execute([$member_id, $group_id, "Member", $meeting_date]); 
        }

    }


    //VALIDATE AND UPLOAD TEXT FILE 
    public function upload_file($text_file){
        $text_file = $_FILES['input_file'];
        
        if($text_file['size'] == 0){
            return "no file"; 
        }elseif($text_file && $text_file['tmp_name']){
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["input_file"]["name"]);
            $fileType = strtolower(pathinfo($_FILES["input_file"]["name"],PATHINFO_EXTENSION));
            
            if($fileType != "txt"){
                return "unsupported";
            }else{
                move_uploaded_file($_FILES["input_file"]["tmp_name"], $target_file);
            }
            
            return $target_file;
        }else{
           return "wrong";
        }
    }



    //GET ALL THE GROUPS BELONGING TO AN ADMIN
    public function get_groups_by_admin($user_id){
        $conn =   $this->db_connect();
        $stmt = $conn->prepare("SELECT * FROM groups WHERE users_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    //FETCH ATTENDANCE
    public function get_attendance($user_id, $group_id, $start_date, $end_date, $criteria){ //criteria is the max number of comments required to mark member present in the meeting
        $attendance = array();
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT users.id AS users_id, members.name, attendance.member_role, groups.id, attendance.meeting_date, count(members.name) AS comment_count
        FROM users 
        JOIN members 
        ON users.id = members.users_id
        JOIN attendance 
        ON members.id = attendance.member_id
        JOIN groups 
        ON attendance.group_id = groups.id 
         WHERE (groups.users_id = ?) AND (groups.id = ?) AND (attendance.meeting_date BETWEEN ? AND ?) 
         GROUP BY members.name");
        $stmt->execute([$user_id, $group_id, $start_date, $end_date]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
        foreach($result as $member){
          if($member['comment_count'] >= $criteria){
              array_push($attendance, $member);
          }
        }
        return $attendance;
    }


    //COUNT MEMBERS IN A GROUP
    public function group_count($group_id){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT id FROM member_group
        WHERE group_id = ?");
        $stmt->execute([$group_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result);
    }


    //GET ALL MEMBERS BY ADMIN
    public function get_members_by_admin($admin_id){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT * FROM members WHERE users_id = ?");
        $stmt->execute([$admin_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //GET MEMBERS BY GROUP
    public function get_members_by_group($group_id){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT members.id AS member_id, members.users_id, members.name AS member_name, member_group.group_id, groups.name AS group_name
        FROM members 
        JOIN member_group
        ON members.id = member_group.member_id
        JOIN groups 
        ON member_group.group_id = groups.id
        WHERE member_group.group_id = ?");
        $stmt->execute([$group_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    //GET MEMBER ROLE
    public function get_member_role($member_id, $group_id){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT member_role 
        FROM attendance 
        WHERE member_id = ? and group_id = ?");
        $stmt->execute([$member_id, $group_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach($result as $role){
            echo $role;
        }

    }


    //MAKE A GROUP MEMBER AN ADMIN 
    public function make_admin($group_id, $member_id){
        $conn = $this->db_connect();
        $sql = $conn->prepare("UPDATE attendance SET member_role = ? WHERE group_id = ? AND member_id = ?;");
        $sql->execute(["Admin", $group_id, $member_id]);
    }

    //TO REMOVE A MEMBER FROM BEING ADMIN
    public function make_member($group_id, $member_id){
        $conn = $this->db_connect();
        $sql = $conn->prepare("UPDATE attendance SET member_role = ? WHERE group_id = ? AND member_id = ?;");
        $sql->execute(["Member", $group_id, $member_id]);
    }


    //GET THE TOTAL COUNT OF ALL THE GROUPS BELONGING TO AN ADMIN
    public function get_group_count($admin_id){
        $result = $this->get_groups_by_admin($admin_id);
        $group_count = count($result);
        return $group_count;
    }

    //GET ALL THE MEMBERS THAT BELONG TO A USER
    public function get_user_members($user_id){
        $conn = $this->db_connect();
        $sql = $conn->prepare("SELECT id FROM members WHERE users_id = ?");
        $sql->execute([$user_id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return count($result);
    }




    

























 

  

    



  
    

 

   
  

    //GET MONTHLY GROUP STATS
    public function get_monthly_stats($start_date, $end_date, $user_id){
        $conn = $this->db_connect();
        $stmt = $conn->prepare("SELECT  count(members.name) AS comment_count
        FROM users 
        JOIN members 
        ON users.id = members.users_id
        JOIN attendance 
        ON members.id = attendance.member_id
        JOIN groups 
        ON attendance.group_id = groups.id 
         WHERE (groups.users_id = ?)  AND (attendance.meeting_date BETWEEN ? AND ?)");
        $stmt->execute([$user_id, $start_date, $end_date]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]["comment_count"];
    }
}


?>

