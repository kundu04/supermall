<?php include ('views/header-script.php'); ?>
</head>
<body>
    <div class="wrapper">
        <!-- Start header area -->
        <header id="header" class="header-area">
            <?php include('views/header-top.php') ?>

            <!-- start main-menu area -->
            <?php include 'views/main-menu.php'; ?>

            <!-- Start mobile menu -->
            <?php include('views/mobile-menu.php'); ?>
        </header>
        <!-- End header area -->
        
        <!-- start our page  content -->
        <div class="container">
            <div class="row">
                <div class="main">
                    <div class="col-md-12">
                        <!-- my-account-area start -->
                        <div class="my-account-area">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
									<?php 
										if(isset($_SESSION['mgs'])){ 
											echo "<div class='alert alert-danger'>".$_SESSION['mgs']."</div>";
									}?>
                                    <div class="my-account-page-content">
                                        <div class="my-account-page-title"><br>
                                            <h1>Reset Password<small> OR <a href="register.php">Create an account</a></small></h1>
                                        </div>
                                    </div>
                                    <form action="forgotPasswordProcess.php" method="POST">
                                        <div class="form-fields">
                                            <div class="form-group">
                                                <label for="email">Email *</label>
                                                <input required type="email" name="email" id="email" placeholder="Enter email..." class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-action">
                                            <input type="submit" name="reset_pass" value="Reset" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- my-account-area end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End our page  content -->

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>

    <?php include('views/footer-script.php'); ?>
</body>
</html>
<?php unset($_SESSION['mgs']); ?>