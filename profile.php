
<?php include_once "./includes/admin-header.php" ?>
  <title>
   Profile
  </title>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  
<?php include_once "./includes/sidebar.php" ?>
  
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php include_once "./includes/navbar.php" ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">User Information</p>
                <button class="btn btn-primary btn-sm ms-auto">Settings</button>
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm"></p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Whatsapp Username</label>
                    <input class="form-control" type="text" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Email address</label>
                    <input class="form-control" type="text" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h5>Update Password</h5>
                </div>
              </div>
              <form action="">
                <div class="row mt-5">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pwd" class="form-control-label">New Password</label>
                      <input class="form-control" name="pwd" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="confirm_pwd" class="form-control-label">Confirm New Password</label>
                      <input class="form-control" name="confirm_pwd" type="text">
                    </div>
                  </div>
                  <div class="col-sm-12 mt-5">
                    <button type="submit" name="change_pwd" class="btn btn-primary mx-3">Change Password</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
  </div>
  <?php include_once "./includes/footer.php" ?>