<?php include ('views/header-script.php'); ?>
<?php if (!empty($_SESSION['cust_id'])) {
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
        
		<?php 

        if(isset($_POST['register']))
		{   
            $columnName = "*";
            $tableName = "customer";
            $exist = $coreModel->selectData($columnName, $tableName);
            foreach($exist AS $eachRow);

            if ($eachRow['email'] == $_POST['email']) {
                $mgs = '
                    <div class="alert alert-danger fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your email already exist!
                    </div>
                    ';
            }else{
            
			$password =  $_POST['password'];
			$cpassword =  $_POST['confirmPassword'];
            
            if ($password == $cpassword) {
                
                $salt = base64_encode(rand(10000, 99999));
                $Pass = $_POST['password'];
                $password = md5($salt.$Pass);
                
				$columnValue["salt"] = $salt;
                $columnValue["cust_name"] = $_POST['name'];
				$columnValue["email"] = $_POST['email'];
				$columnValue["password"] = $password;

                # CONFIGURE THE MAIL SETTINGS / CHECKING FROM YOUR cPANEL
                $mailConfig['host'] = MAIL_HOST_1;
                $mailConfig['port'] = MAIL_PORT_1;
                $mailConfig['email'] = OUTGOING_MAIL_ID_1;
                $mailConfig['pass'] = OUTGOING_MAIL_PASS_1;
                $mailConfig['name'] = "Supermall";
                $mailConfig['type'] = "text/html"; // "text/html";
                
                # PREPARE YOUR MAIL
				
				$rand_val = rand(100000, 999999);
				$access_token = base64_encode($rand_val);
				$columnValue['access_token'] = $rand_val;
				$columnValue['time_diff'] = date("Y-m-d H:i:s");
				$url = '<a href="localhost/supermall/email-verify.php?verify='.$access_token.'"> Verify</a>';
								
                $mailDetails['title'] = "Signup Success!";
                $mailDetails['body'] = "Hello, ".$_POST['name']."<br /><br />Welcome to Supermall<br /><br />Please click the link to verify your account ".$url."<br /><br />Username: ".$_POST['email']."<br /><br />Please remember this user login details for further use.";
                $mailDetails['attachment']['file_with_path'] = "http://localhost/supermall/img/about/about_us.jpg";
				$mailDetails['attachment']['file_new_name'] = "aboutNew_.jpg";
                # PREPARE YOUR RECEIVERS
                $mailReceiver = $_POST['email'];
                # SEND THE MAIL
                $mailResult = $coreControl->smtpMail($mailConfig, $mailDetails, $mailReceiver);
				$queryResult = $coreModel->insertData($tableName, $columnValue);
				
				
				if($queryResult['no_of_row_inserted'] > 0 && $mailResult)
                {
					$mgs = '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         You have successfully registered, Please check your email!
                    </div>
                    ';
                }
                
			}else{
				$mgs =  '
                <div class="alert alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                     Your password did not matched!
                </div>
                ';
			}}
			
            
		}
		?>
		
        <!-- start our page  content -->
        <div class="container">
            <div class="row">
                <div class="main">
                    <div class="col-md-12">
                        <!-- my-account-area start -->
                        <div class="my-account-area">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
								<?php if(isset($mgs)){ echo $mgs; } ?>
                                    <div class="my-account-page-content">
									<?php if(isset($_SESSION['mgs'])){ echo $_SESSION['mgs']; } ?>
                                        <div class="my-account-page-title"><br>
                                            <h1>Create an Account<small> OR <a href="login.php">Login</a></small></h1>
                                        </div>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="form-fields">
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input required type="name" name="name" id="name" placeholder="Enter name..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email *</label>
                                                <input required type="email" name="email" id="email" placeholder="Enter email..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password *</label>
                                                <input required type="password" name="password" id="password" placeholder="Enter password..." class="form-control">
                                            </div>
											
											<div class="form-group">
                                                <label for="Password">Confirm Password *</label>
                                                <input required type="password" name="confirmPassword" id="confirmPassword" placeholder="Re-Enter password..." class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-action">
                                            <input type="submit" name="register" value="Create" />
                                            <label><input required type="checkbox" /> I Accept the <a href="">Terms & Conditions</a></label>
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