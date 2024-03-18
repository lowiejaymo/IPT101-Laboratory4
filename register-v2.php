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
                  I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">terms and conditions</a>
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

        <a href="login-v2.php" class="text-center">I already have a account</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Terms and Conditions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ol>
            <li><strong>Introduction</strong><br>
              These Terms and Conditions govern your use of the registration form provided by us. By using this
              registration form, you agree to comply with and be bound by these Terms and
              Conditions. If you disagree with any part of these Terms and Conditions, you must not use this
              registration form.
            </li>
            <li><strong>Registration Information</strong><br>
              By filling out and submitting the registration form, you agree to provide accurate, current, and complete
              information about yourself as prompted by the form. You also agree to maintain and promptly update this
              information to keep it accurate, current, and complete.
            </li>
            <li><strong>Privacy</strong><br>
              Your privacy is important to us. All information provided in the registration form will be handled in
              accordance with our Privacy Policy. By using this registration form, you consent to the collection and use
              of your information as described in our Privacy Policy.
            </li>
            <li><strong>Security</strong><br>
              You are responsible for maintaining the confidentiality of any of your information and passwords
              associated with the registration form. You agree not to share your password with anyone else or allow anyone else
              to access your account. You are solely responsible for any activities that occur under your account.
            </li>
            <li><strong>Acceptable Use</strong><br>
              You agree to use the registration form only for lawful purposes and in a manner consistent with these
              Terms and Conditions. You agree not to use the registration form in any way that could damage, disable,
              overburden, or impair our servers or networks, or interfere with any other party's use and enjoyment of
              the registration form.
            </li>
            <li><strong>Modification of Terms</strong><br>
              We reserve the right to modify these Terms and Conditions at any time without prior notice. Your continued
              use of the registration form after any such modifications indicates your acceptance of the modified Terms
              and Conditions. It is your responsibility to review these Terms and Conditions periodically for any
              changes.
            </li>
          </ol>
          <p>By using this registration form, you acknowledge that you have read, understood, and agree to be bound by
            these Terms and Conditions.</p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>

</html>