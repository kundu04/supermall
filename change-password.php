<?php include ('views/header-script.php'); ?>
<?php if (empty($_SESSION['cust_id'])) {
    header('Location:index.php');
} ?>
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
                                    <div class="my-account-page-content">
									<?php if(isset($_SESSION['mgs'])){ echo $_SESSION['mgs'];}?>
                                        <div class="my-account-page-title"><br>
                                            <h1>Change password</h1>
                                        </div>
                                    </div>
                                    <form action="changePasswordProcess.php" method="POST">
                                        <div class="form-fields">
                                            <div class="form-group">
                                                <label for="current-pass">Current Password *</label>
                                                <input required type="password" name="current-pass" id="current-pass" placeholder="Enter current password..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="new-pass">New Password *</label>
                                                <input required type="password" name="new-pass" id="new-pass" placeholder="Enter new password..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="conf-pass">Confirm Password *</label>
                                                <input required type="password" name="conf-pass" id="conf-pass" placeholder="Enter confirm password..." class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-action">
                                            <input type="submit" name="change_pass" value="Change" />
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