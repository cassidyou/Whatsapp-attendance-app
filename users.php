<?php 
include_once "./includes/admin-header.php"; 
include_once "./classes/functions-class.php";


$contrl = new Function_bank;
$groups = $contrl->get_groups_by_admin($_SESSION['id']);


// print_r($all_members);

if(isset($_POST["make_member"])){
    $group_id = $_POST["group_id"];
    $member_id = $_POST["member_id"];

    $contrl->make_member($group_id, $member_id);

}

if(isset($_POST["make_admin"])){
    $group_id = $_POST["group_id"];
    $member_id = $_POST["member_id"];

    $contrl->make_admin($group_id, $member_id);
}
?>
<style>
    .action-btn{
        position: absolute;
        left: 0;
        top: 5px;  
    }


   
</style>
  <title>
  Users
  </title>
  </head>
  <body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include_once "./includes/sidebar.php" ?>
<?php include_once "./includes/navbar.php" ?>

 
<main class="container-fluid py-4">
    
    <div class="row mt-5"></div>
      <div class="row mt-5 py-5">
        <div class="col-sm-12">
            <div class="card z-index-2">
                <div class="card-header pb-3 pt-3 bg-transparent">
                    <caption class="text-capitalize text-center mb-5 mt-3">All Members List</caption>
                   <form action="" method="POST">
                        <div class="row justify-content-between my-3">
                            <div class="col-sm-5 my-3">
                                <select name="group_id" class="form-control" onchange='this.form.submit()'>
                                    <option value="Choose" >Choose Group</option>
                                    <?php foreach($groups as $group) : ?>
                                        <option value='<?php echo $group['id'] ?>'>
                                            <?php echo $group["name"]  ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                   </form>
                 

                 

                   <?php if(isset($_POST['group_id'])) : ?>
                    <?php
                        $group_id = $_POST["group_id"];
                         $members = $contrl->get_members_by_group($group_id); 
                        //  print_r($members);
                         ?>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <tr>
                            <th class="col-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                            <th class="col-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">fullname</th>
                            <th class="col-1 text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                            <th class="col-3 text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Group Name</th>
                            <th class="col-4 text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>

                            </tr>
                        
                            <?php foreach($members as $index => $member) : ?>
                                <?php $index += 1 ?>
                                <tr>
                                    <td><?php echo $index ?></td>
                                    <td>
                                        <h6 class="mb-0 text-sm"><?php echo $member["member_name"] ?></h6>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <?php  
                                                $member_role = $contrl->get_member_role($member['member_id'], $group_id)
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-left">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $member["group_name"] ?></span>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <form method="POST" class="d-flex justify-content-between align-items-center">
                                            <input type="hidden" value="<?php echo $group_id; ?>" name="group_id">
                                            <input type="hidden" value="<?php echo $member["member_id"]; ?>" name="member_id">
                                            <div>
                                                <input type="submit" name="make_admin" class="btn btn-success px-2 mx-1" value="Make admin">
                                            </div>    
                                            <div>
                                                <input type="submit" name="make_member" class="btn btn-danger px-2 mx-1" value="Make member">
                                            </div>    
                                        </form>
                                        
                                        
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            
                        </table>
                    </div>  
                   <?php endif ?>

                   <?php if(!isset($_POST['get_all_members']) && !isset($_POST['group_id'])) : ?>
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

