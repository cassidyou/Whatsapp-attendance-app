<?php 
include_once "./includes/admin-header.php";
include_once "./classes/functions-class.php";

$contrl = new Function_bank;
$groups = $contrl->get_groups_by_admin($_SESSION['id']);

 ?>
  <title>
   Upload Chat
  </title>
  </head>
  <body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include_once "./includes/sidebar.php" ?>
<?php include_once "./includes/navbar.php" ?>

 
<main class="container-fluid py-4">    
      <div class="row my-5"></div>
      <div class="row mt-5">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize text-left mb-3 mt-3">Upload Chat</h6>
              <?php if(isset($_GET['good'])) : ?>
                  <div class='alert text-light alert-success mx-4'>
                       Your file is uploaded successfully!
                      </div>
              <?php endif ?>

              

              <form action="includes/function-controller.php" method="POST" enctype="multipart/form-data">
                    <div class="row text-center my-2">
                        <div class="col-sm-5 my-3">
                        <select name="group_id" class="form-control">
                                <?php foreach($groups as $group) : ?>
                                    <option value='<?php echo $group["id"] ?>'>
                                        <?php echo $group["name"]  ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-sm-7 my-3">
                            <div>
                                <input class="form-control form-control-md" name="input_file" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-sm-10"><input type="hidden" name="admin_id" value="<?php echo $_SESSION["id"] ?>" ></div>
                        <div class="col-sm-2 text-right">
                            <input type="submit" name="upload" class="btn btn-success" value="Upload">
                        </div>
                    </div>
              </form>
             
            </div>
          </div>
        </div>
        <div class="col-lg-1"></div>

      </div>
  
      </div>
</main>
      
<?php include_once "./includes/footer.php" ?>



