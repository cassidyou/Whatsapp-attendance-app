<?php include_once "./includes/header.php" ?>

  <title>
   Sign In
  </title>
</head>

<body class="">

  <main class="main-content  mt-0 ">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h3 class="text-white mb-2 mt-5">Sign In</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center mb-5">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h6>Enter your email and password to login</h6>
            </div>
            <?php 
              if(isset($_GET['incorrect'])){
                echo "<div class='alert alert-warning mx-4'> Incorrect email or password </div>";
              }
            ?>

            <div class="card-body">
              <form id="login_form" method="post" action="includes/sign-in-controller.php">
                <div class="mb-3">
                  <input type="email" class="form-control email" placeholder="Email" name="email" id="email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control password" placeholder="Password" name="password" id="password">
                </div>
                <div class="text-center">
                  <button type="submit" name="sign_in" id="btn_submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign in</button>
                </div>
                <p class="text-sm mt-3 mb-0">Don't have an account? <a href="sign-up.php" class="text-dark font-weight-bolder">Sign up</a></p>
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
      let email = $("#email");
      let password = $("#password");
      let btn_login = $("#btn_submit");
      let login_form = $("#login_form")

      btn_login.click(function(){
        if(email.val() == "" || password.val() == ""){
          alert("Please fill all fields");
          login_form.submit(function(e){
            return false;
          })
        }else{
          login_form.submit(function(e){
            return true;
          })
        }
      })
    })
  </script>