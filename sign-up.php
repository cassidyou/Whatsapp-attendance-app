<?php include_once "./includes/header.php" ?>

  <title>
    Register
  </title>
</head>

<body class="">

  <main class="main-content  mt-0 ">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h3 class="text-white mb-2 mt-5">Registration</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center mb-5">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Fill in your details to register</h5>
            </div>

            <div id="alert"></div>
            <?php 
              if(isset($_GET['exists'])){
                echo "<div class='alert text-bold alert-warning mx-4'>
                        User exists! 
                      </div>";
              }
              if(isset($_GET['registered'])){
                echo "<div class='alert alert-success mx-4'>
                        Your account is successfully created, please proceed to login. 
                      </div>";
              }
            ?>
    
            <div class="card-body">
              <form id="sign-up-form" method="POST" action="includes/sign-up-controller.php">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Whatsapp Username" name="full_name" id="full_name">
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                </div>
                <div class="text-center">
                  <button type="submit" name="sign_up" id="btn_submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="sign-in.php" class="text-dark font-weight-bolder">Sign in</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php include_once "./includes/footer.php" ?>

<script>
  $(document).ready(function(){
    let fullname = $("#full_name");
    let email = $("#email");
    let password = $("#password");
    let confirm_password = $("#confirm_password");
    let btn_submit = $("#btn_submit");

 
    btn_submit.click(function(){
      // console.log(fullname.val())
      if(fullname.val() == "" || email.val() == "" || password.val() == "" || confirm_password.val() == ""){
        alert("Please fill all fields");
        $("#sign-up-form").submit(function(e){
          return false;
        })
      }else{
        if(password.val() !== confirm_password.val()){
          alert("Password Mismatch");
          $("#sign-up-form").submit(function(e){
            return false;
          })
        }else if(password.val().length <= 7){
          alert("Password must be at least 8 characters");
          $("#sign-up-form").submit(function(e){
            return false;
          })
        }else{
          $("#sign-up-form").submit(function(e){
            return true;
          })
        }
      }

      

    })
  })
</script>

