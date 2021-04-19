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
                                <div class="col-md-6 col-md-offset-3">
		
		<?php 
		if(isset($_POST['edit_profile'])){
			if($_POST['country'] != 0 && $_POST['city'] != 0){				
				$columnValue["cust_name"] = $_POST['name'];
				$columnValue["phone"] = $_POST['phone'];
				$columnValue["address"] = $_POST['address'];
				$columnValue["country_id"] = $_POST['country'];
				$columnValue["city_id"] = $_POST['city'];
				$columnValue["zipcode"] = $_POST['zipcode'];
							
			$abc = $coreModel->updateData("customer", $columnValue, array("customer_id"=>$_SESSION['cust_id']));
			
			if($abc > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					Your profile has been successfully Updated !
    				</div>';
						
						header("Refresh: 2; url = profile.php");
						ob_end_flush();
					
    			}else{
					echo '
    				<div class="alert alert-danger fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					Your profile has not been Updated !
    				</div>';
				}
			}else{
				echo '
					<div class="alert alert-danger fade in">
						<button type="button" class="close close-sm" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
							Please select Country and City !
					</div>';
			}
		}
		
		?>
		
									<div class="my-account-page-content">
                                        <div class="my-account-page-title"><br>
                                            <h1>Edit Profile <small>OR <a href="profile.php">back to my profile</a></small></h1>
                                        </div>
                                    </div>
                                    <form action="" method="POST">
                                      <div class="form-group ">
                                        <label class="control-label" for="name">Full Name <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="name" name="name" value="<?php echo $customer['cust_name']; ?>" type="text"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-user">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="phone">Phone <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" placeholder="Enter mobile number" type="text"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-phone">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="address">Address <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="address" name="address" value="<?php echo $customer['address']; ?>" placeholder="Enter address" type="text" />
                                          <div class="input-group-addon">
                                          <i class="fa fa-location-arrow">
                                          </i>
                                          </div>
                                        </div>
                                      </div>
									
									  <div class="form-group ">
                                        <label class="control-label" for="country">Country <span class="star">*</span>
                                        </label>
                                        <select required class="select form-control" id="country" name="country">
											<option>Select country</option>
									
							<?php 
							$countryAll = $myModel->customQuery("SELECT * FROM country WHERE status = 1");
								
								foreach ($countryAll as $countryList) { ?>
										
											<option value="<?php echo $countryList['country_id']?>" <?php if(@$custArea['country_id']==$countryList['country_id']){ echo "selected='selected'"; } ?>><?php echo $countryList['name']?></option>
							
							<?php }	?>       
										</select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="city">City <span class="star">*</span>
                                        </label>
                                        <select required class="select form-control" id="city" name="city">
											
											<option value="<?php echo @$custArea['city_id']; ?>"><?php if(@$custArea['cityName'] != null) {echo $custArea['cityName'];}else{ echo 'Select City'; } ?></option>
										  
                                        </select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="zipcode">Zip code <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="zipcode" name="zipcode" value="<?php echo $customer['zipcode']; ?>" placeholder="Enter zip code" type="text"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-sort-numeric-desc">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <div>
                                         <button class="btn btn-primary" name="edit_profile" type="submit"><i class="fa fa-paper-plane"></i> Update</button>
                                         <a class="btn btn-danger" href="profile.php"><i class="fa fa-ban"></i> Cancel</a>
                                        </div>
                                      </div><br>

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