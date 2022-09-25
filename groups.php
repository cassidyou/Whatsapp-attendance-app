<?php 
include_once "./includes/admin-header.php";
include_once "./classes/functions-class.php";

$contrl = new Function_bank;
$groups = $contrl->get_groups_by_admin($_SESSION['id']);




?>
  <title>
  Groups
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
                    <caption class="text-capitalize text-center mb-5 mt-3">Group List</caption>
                    
                      <?php if(isset($groups)) : ?>
                        <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Group Name</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Members</th>
                            </tr>
                            <?php foreach($groups as $index => $group) : ?>
                                <?php  
                                    $index += 1;
                                ?>
                                <tr>
                                    <td class="opacity-7"><?php echo $index ?></td>
                                    <td>
                                        <h6 class="mb-0 text-sm opacity-7"><?php echo $group["name"] ?></h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            <?php
                                               $group_count = $contrl->group_count($group['id']);
                                               if(isset($group_count)){
                                                echo $group_count;
                                               }else{
                                                echo "0";
                                               }
                                              ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                      <?php endif ?>

                      <?php if(!isset($groups)) : ?>
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

