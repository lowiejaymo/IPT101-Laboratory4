<?php
session_start();

if (isset($_SESSION['verify'])) {
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Verification</title>
        
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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- This web utilized bootstrap.css -->
        <link rel="stylesheet" type="text/css" href="bootstrap.css">

    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="index5.php" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="card-body">
                    <h1 style="text-align:center"><i class="bi bi-patch-check"></i></h1>
                    <h6 class="success-text" style="text-align:center">Verification code sent to your email</h6> <br>

                    <!-- This error message will appear when there is error with user's input -->
                    <?php if (isset($_GET['error'])) { ?>
                        <!-- alert alert-danger, used to make the error message color into red -->
                        <div class="alert alert-danger">
                            <?php echo $_GET['error']; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <!-- alert alert-danger, used to make the error message color into red -->
                        <div class="alert alert-success">
                            <?php echo $_GET['success']; ?>
                        </div>
                    <?php } ?>

                    <!-- auto filled email address  -->
                    <form action="indexes/manualverify.php" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                            <input type="text" class="form-control" name="email"
                                value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <!-- Verification Code Input -->
                        <div class="input-group mb-3">
                            <!-- This line used to have user icon beside a password input-->
                            <!-- <i class="bi bi-person"> used to display an lock icon -->
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-braces"></i></span>
                            <input type="text" class="form-control" name="v_code" placeholder="Verification Code">
                        </div>

                        <!-- /.col -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block" value="Login"
                                name="login">Verify</button>
                        </div>
                        <!-- /.col -->
                    </form>

                    
                    <hr>
                    <form action="indexes/resend-verification-code.php" method="post">
                    <?php if (isset($_GET['newsuccess'])) { ?>
                        <!-- alert alert-danger, used to make the error message color into red -->
                        <div class="alert alert-success">
                            <?php echo $_GET['newsuccess']; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['newerror'])) { ?>
                        <!-- alert alert-danger, used to make the error message color into red -->
                        <div class="alert alert-danger">
                            <?php echo $_GET['newerror']; ?>
                        </div>
                    <?php } ?>
                        <h6 class="success-text" style="text-align:left">Didn't received any erification Code?</h6>
                        <input type="hidden" name="email" value="<?php echo $email; ?>">

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" value="resend_code" name="resend">Resend
                                Verification Code</button>
                        </div>
                    </form>
                </div>



            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
    </body>

    </html>

    <?php
} else {
    header("Location: register-v2.php");
    exit();
}
?>