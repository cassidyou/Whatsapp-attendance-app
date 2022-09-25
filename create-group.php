<?php include_once "./includes/admin-header.php" ?>
  <title>
    Create Group
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
              <h6 class="text-capitalize text-left mb-5 mt-3">Add New Whatsapp Group</h6>
              <?php
              if(isset($_GET['exists'])){
                echo "<div class='alert  alert-warning mx-4'>
                       Group exists! 
                      </div>";
              }
              if(isset($_GET['created'])){
                echo "<div class='alert text-light alert-success mx-4'>
                       Group successfully created! 
                      </div>";
              }
              ?>
              <form action="includes/function-controller.php" method="POST" id="add_group_form">
                    <div class="row text-center">
                        <div class="col-sm-9 my-3">
                            <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Group Name">
                        </div>
                        <div class="col-sm-3 my-3">
                            <input type="submit" name="add_group" id="add_group_btn" value="Add Group" class="btn btn-success">
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

<script>
  $(document).ready(function(){
    let group_name = $("#group_name");
    let submit_btn = $("#add_group_btn");
    let add_group_form = $("#add_group_form")
    submit_btn.click(function(){
      if(group_name.val() != "" && group_name.val().length > 4){
        
        $("form#add_group_form").submit();
      }
      
      if(group_name.val() == ""){
        alert("Please enter group name");
        add_group_form.submit(function(e){
          return false;
        })
      }else if(group_name.val().length < 4){
        alert("Group name is too short");
        add_group_form.submit(function(e){
          return false;
        })
      } 

    })
  })
</script>
