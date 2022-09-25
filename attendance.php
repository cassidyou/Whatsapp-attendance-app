<?php 
include_once "./includes/admin-header.php";
include_once "./classes/functions-class.php";


$contrl = new Function_bank;
$groups = $contrl->get_groups_by_admin($_SESSION['id']);
// print_r($groups);



//FETCHING ATTENDANCE
function attendance(){
    global $contrl;
    if(isset($_POST["get_attendance"])){
        $start_date = $contrl->cleanInput($_POST["start_date"]);
        $end_date = $contrl->cleanInput($_POST["end_date"]);
        $comment_count = $contrl->cleanInput($_POST["comment_count"]);
        $group_id = $contrl->cleanInput($_POST["group_id"]);
        $user_id = $contrl->cleanInput($_SESSION["id"]);
     
        $attendance = $contrl->get_attendance($user_id, $group_id, $start_date, $end_date, $comment_count);
        $member_roles = array_column($attendance, "member_role");
       if(array_search("Admin", $member_roles) !== false){
        return $attendance;
       } 
         
     }  
}

$attendance = attendance();


?>

  <title>
   Attendance
  </title>
  </head>
  <body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include_once "./includes/sidebar.php" ?>
<?php include_once "./includes/navbar.php" ?>

 
<main class="container-fluid py-4">
      <div class="row mt-5">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <caption class="text-capitalize text-center mb-5 mt-3">Track Attendance</caption>
              <form  method="POST" id="attendance_form">
                    <div class="row text-left">
                        <div class="col-sm-4 my-3">
                        <label for="start_date"><h6>Start Date</h6></label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                        <div class="col-sm-4 my-3">
                        <label for="end_date"><h6>End Date</h6></label>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        <div class="col-sm-4 my-3">
                        <label for="Chat criteria"><h6>Chat Criteria</h6></label>
                            <input type="Number" class="form-control" name="comment_count" id="criteria" placeholder="Number of chat criteria">
                        </div>
                    </div>
                    <div class="row justify-content-between my-3">
                        <div class="col-sm-8 my-3">
                            <select name="group_id" class="form-control">
                                <?php foreach($groups as $group) : ?>
                                    <option value='<?php echo $group['id'] ?>'>
                                        <?php echo $group["name"]  ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-sm-4 text-center text-right my-3">
                            <input type="submit" value="Get Attendance" id="attendance_btn" name="get_attendance" class="btn btn-success">
                        </div>
                    </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-1"></div>

      </div>
      <div class="row mt-5">
        <div class="col-sm-12">
            <div class="card z-index-2">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <caption class="text-capitalize text-center mb-5 mt-3"><h4>Attendance list</h4></caption>
                    
                    <?php if(isset($attendance)): ?>
                        <div class="row">
                            <div class="col-sm-12 text-right mt-2 mb-3">Total Attendance: <?php echo count($attendance) ?> member(s)</div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fullname</th>
                                <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Meeting Date</th>
                                </tr>
                                <?php foreach($attendance as $index => $attended) :?>
                                    <?php $index += 1  ?>
                                    
                                    <tr>
                                        <td><?php echo $index ?></td>
                                        <td>
                                            <h6 class="mb-0 text-sm"><?php echo $attended["name"] ?></h6>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo $attended["member_role"] ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $attended["meeting_date"] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                              
                              
                            </table>
                        </div>
                    <?php endif ?>

                    <?php if(!isset($attendance)) : ?>
                        <div class="row">
                            <div class="col-sm-12 text-center opacity-7 mt-4 mb-5">
                                <img src="assets/img/no-record-found.png" alt="No Record Found" class="img-fluid">
                            </div>
                        </div>
                    <?php endif ?>
                    

                </div>
            </div>
        </div>
      </div>
  
      </div>
  </main>
      
<?php include_once "./includes/footer.php" ?>

<script>
    $(document).ready(function(){
        let form = $("#attendance_form");
        let start_date = $("#start_date");
        let end_date = $("#end_date");
        let attend_btn = $("#attendance_btn");
        let criteria = $("#criteria");

        attend_btn.click(function(){
            if(new Date(start_date.val()) <= new Date(end_date.val()) && criteria.val() > 0){
                form.submit(function(e){ return true; })
                form.submit();
            }
            
            if (start_date.val() == "" || end_date.val() == "" || criteria.val() == ""){
                alert("Please fill all fields");
                form.submit(function(e){ return false;  })

            } else if(criteria.val() <= 0){
                alert("Criteria can not negative or zero");
                form.submit(function(e){ return false; })

            }else if(new Date(start_date.val()) > new Date(end_date.val())){
                alert("Invalid date range. End date can not be earlier than start date.")
                form.submit(function(e){ return false})
            }
            
        })














    })
</script>

