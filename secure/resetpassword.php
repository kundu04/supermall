<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">
    <title>Reset Password</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
</head>

<body class="login-body">
<div class="container">    
    <form class="form-signin" action="resetPasswordProcess.php" method="post">
        <div class="form-signin-heading text-center">
            <h5 class="sign-title">Reset Password</h5>    
        </div>
		<?php if(isset($_SESSION['mgs'])){ ?><div class="alert alert-danger"><?php echo $_SESSION['mgs']; ?></div> <?php } ?>
        <div class="login-wrap">
            <input type="password" class="form-control" name="password" placeholder="New password" required >
            <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm password">
            <input type="hidden" value="<?php echo $_GET['token']; ?>" name="token" >

            <button class="btn btn-lg btn-login btn-block" type="submit" name="reset">
                <i class="fa fa-check"></i>
            </button>
        </div>
    </form>
</div>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>

</body>
</html>
<?php unset($_SESSION['mgs']); ?>
