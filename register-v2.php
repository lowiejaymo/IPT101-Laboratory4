<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>
  
  <link rel="icon" type="image/ico" href="favicon.ico">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/dist/css/adminlte.min.css">
  <style>
    .rounded-image {
      width: 100px;
      /* Adjust as needed */
      height: 100px;
      /* Adjust as needed */
      border-radius: 50%;
      /* Create a circular shape */
      object-fit: cover;
      /* Ensure the entire image is visible without stretching */
    }
  </style>
</head>

<body class="hold-transition register-page">
  <div class="register-box" style="width: 650px">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="https://adminlte.io/" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="indexes/signup-be.php" method="post">
          <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger">
              <?php echo $_GET['error']; ?>
            </div>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success">
              <?php echo $_GET['success']; ?>
            </div>
          <?php } ?>

          <p class="text-muted">Note: Fields marked with an asterisk (*) are required.</p>

            <!-- Label for Fullname -->
          <label for="Fullname" class="fw-bold">Fullname</label>
          <div class="row mb-3 ">
            <!-- Last Name Input -->
            <div class="col-md-4">
                    <?php if (isset($_GET['lname'])) { ?>
                        <input type="text" 
                               class="form-control" 
                               name="lastname" 
                               placeholder="Last Name*"
                               pattern="^[^0-9]+$" 
                               title="Numbers are not allowed in this field"
                               value="<?php echo $_GET['lname']; ?>">
                    <?php } else { ?>
                        <input type="text" 
                               class="form-control" 
                               name="lastname" 
                               placeholder="Last Name*"
                               pattern="^[^0-9]+$"
                               title="Numbers are not allowed in this field"
                               >
                    <?php } ?>
                </div>




            
            <!-- Firstname Input -->
            <div class="col-md-4">
                    <?php if (isset($_GET['fname'])) { ?>
                        <input type="text" 
                               class="form-control" 
                               name="firstname" 
                               placeholder="First Name*"
                               pattern="^[^0-9]+$" 
                               title="Numbers are not allowed in this field"
                               value="<?php echo $_GET['fname']; ?>">
                    <?php } else { ?>
                        <input type="text" 
                               class="form-control" 
                               name="firstname" 
                               placeholder="First Name*"
                               pattern="^[^0-9]+$"
                               title="Numbers are not allowed in this field"
                               >
                    <?php } ?>
                </div>
            <!-- Middle Name Input -->
            <div class="col-md-4">
                    <?php if (isset($_GET['mname'])) { ?>
                        <input type="text" 
                               class="form-control" 
                               name="middlename" 
                               placeholder="Middle Name"
                               pattern="^[^0-9]+$" 
                               title="Numbers are not allowed in this field"
                               value="<?php echo $_GET['mname']; ?>">
                    <?php } else { ?>
                        <input type="text" 
                               class="form-control" 
                               name="middlename" 
                               placeholder="Middle Name"
                               pattern="^[^0-9]+$"
                               title="Numbers are not allowed in this field"
                               >
                    <?php } ?>
                </div>
          </div>
            <!-- Username Input -->
            <div class="mb-3">
                <!-- fw-bold used to make the label 'User Name' into bold -->
                <!-- Username input -->
                <label for="User Name" class="fw-bold">User Name</label>
                <?php if (isset($_GET['uname'])) { ?>
                        <input type="text" 
                               class="form-control" 
                               name="uname" 
                               placeholder="User Name*"
                               value="<?php echo $_GET['uname']; ?>">
                    <?php } else { ?>
                        <input type="text" 
                               class="form-control" 
                               name="uname" 
                               placeholder="User Name*"
                               >
                    <?php } ?>
              
            </div>
          <!-- Email Address Input -->
          <div class="mb-3">
                <!-- fw-bold used to make the label 'Email Address' into bold -->
                <label for="Email Address" class="fw-bold">Email Address</label>
                <?php if (isset($_GET['email'])) { ?>
                        <input type="email" 
                               class="form-control" 
                               name="email" 
                               placeholder="Email Address*"
                               value="<?php echo $_GET['email']; ?>">
                    <?php } else { ?>
                        <input type="email" 
                               class="form-control" 
                               name="email" 
                               placeholder="Email Address*"
                               >
                    <?php } ?>
            </div>
          <!-- Password Input -->
          <div class="mb-3">
                <!-- fw-bold used to make the label 'Password' into bold -->
                <!-- Password input -->
                <label for="Password" class="fw-bold">Password</label>
                <?php if (isset($_GET['pass'])) { ?>
                        <input type="password" 
                               class="form-control" 
                               name="password" 
                               placeholder="Password*"
                               value="<?php echo $_GET['pass']; ?>">
                    <?php } else { ?>
                        <input type="password" 
                               class="form-control" 
                               name="password" 
                               placeholder="Password*"
                               >
                    <?php } ?>
            </div>
          <!-- Retyping Password Input -->
          <div class="mb-3">
                <!-- fw-bold used to make the label 'Retype Password' into bold -->
                <!-- Retype Password input -->
                <label for="Retype Password " class="fw-bold">Retype Password</label>
                <?php if (isset($_GET['repass'])) { ?>
                        <input type="password" 
                               class="form-control" 
                               name="repassword" 
                               placeholder="Retype Password*"
                               value="<?php echo $_GET['repass']; ?>">
                    <?php } else { ?>
                        <input type="password" 
                               class="form-control" 
                               name="repassword" 
                               placeholder="Retype Password*"
                               >
                    <?php } ?>
            </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms"  name="tandc">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms and conditions</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name = "register" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
<!--
        <div class="social-auth-links text-center">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>-->

        <a href="login-v2.php" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>

</html>