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

        if(isset($_POST["login"]))
        {
            $columnName = "*";
            $tableName = "customer";
            $data = $coreModel->selectData($columnName, $tableName, array('email' => $_POST["email"] ));
            if(!empty($data)){
                $password = $data[0]['salt'].$_POST['password'];
                if($data[0]['password'] == md5($password)){
                    
                    if ($data[0]['status'] == 'Inactive') {
                        $mgs =  
                        '<div class="alert alert-danger fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i></button>
                             Please verify your email before you login!
                        </div>
                        ';
                    }else{
                        $_SESSION['cust_id'] =   $data[0]['customer_id'];
                        $_SESSION['cust_name'] = $data[0]['cust_name'];
						
					    if(isset($_SESSION['wishlist_product_id']) && $_SESSION['wishlist_product_id']!=''){
							$pro_id = ceil($_SESSION['wishlist_product_id']);
							$cust_id = ceil($_SESSION['cust_id']);
							
							$stmt = $coreModel->insertData("customer_wishlist", array("customer_id"=>$cust_id, "product_id"=>$pro_id));
                           }
                        
						if(isset($_SESSION['redirect_url']) && $_SESSION['redirect_url']!='')
						           $redirect_url = $_SESSION['redirect_url'];
						else
							       $redirect_url = 'index.php';
						
                        header("Location:".$redirect_url);
                    }
                }
                else{
                    $mgs =  
                    '<div class="alert alert-danger fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your password did not matched!
                    </div>
                    ';
                }   
            }
            else{
                
                $mgs =  
                '<div class="alert alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                     Your email did not matched!
                </div>
                ';
            }   
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
                                <?php 
                                if(isset($_SESSION['mgs'])){ 
                                    echo "<div class='alert alert-danger'>".$_SESSION['mgs']."</div>";
                                    }?>
                                <?php if(isset($mgs)){ echo $mgs; } ?>
                                    <div class="my-account-page-content">
                                        <div class="my-account-page-title"><br>
                                            <h1>Login<small> OR <a href="register.php">Create an account</a></small></h1>
                                        </div>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="form-fields">
                                            <div class="form-group">
                                                <label for="email">Email *</label>
                                                <input required type="email" name="email" id="email" placeholder="Enter email..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password *</label>
                                                <input required type="password" name="password" id="password" placeholder="Enter password..." class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-action">
                                            <p class="lost_password"><a href="forget-password.php">Forgot your password?</a></p>
                                            <input type="submit" name="login" value="login" />
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