<?php include ('views/header-script.php'); ?>
<?php  
if(!empty($_SESSION['cust_id'])){

	$cust_id = $_SESSION['cust_id'];

	$custDetails = $myModel->customQuery("SELECT customer.* FROM customer WHERE customer_id = '$cust_id'");
	
	foreach($custDetails AS $customer);	
	
	$custLocation = $myModel->customQuery("SELECT country.country_id, country.name as countryName, city.city_id, city.name as cityName FROM customer, country, city WHERE customer.customer_id = '$cust_id' AND customer.country_id = country.country_id AND customer.city_id = city.city_id");
	
	foreach($custLocation AS $custArea);
	
} else {
		
	header("Location:login.php");
}

?>

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
                                <div class="col-md-6 col-md-offset-3"><br>
                                    <div class="my-account-page-content">
                                        <div class="my-account-page-title">
                                            <h1>Customer Profile <small>OR <a href="edit-profile.php">Edit profile</a></small></h1>
                                        </div>
                                    </div>
									
                                    <table class="table">
                                      <tr>
                                        <td><b>Name :</b></td>
                                        <td><?php echo @$customer['cust_name']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Email :</b></td>
                                        <td><?php echo @$customer['email']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Mobile :</b></td>
                                        <td><?php echo @$customer['phone']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Address :</b></td>
                                        <td><?php echo @$customer['address']; ?></td>
                                      </tr>
                                      
                                      <tr>
                                        <td><b>Country :</b></td>
                                        <td><?php echo @$custArea['countryName']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>City :</b></td>
                                        <td><?php echo @$custArea['cityName']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Zip code :</b></td>
                                        <td><?php echo @$customer['zipcode']; ?></td>
                                      </tr>
                                      
                                    </table>

                                    <a href="edit-profile.php"><button type="submit" name="edit_profile" class="btn btn-primary">Edit Profile</button></a>
                                    
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