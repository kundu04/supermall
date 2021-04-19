<?php include ('views/header-script.php'); ?>

<?php 
	if(empty($_SESSION['cust_id']) && $_SESSION['cust_id']==''){
		header("Location:login.php");
		exit();
	}
?>
<?php
if(!empty($_SESSION['cust_id']) && !empty($_SESSION['cart']))
{

	$cust_id = $_SESSION['cust_id'];

	$custDetails = $myModel->customQuery("SELECT customer.* FROM customer WHERE customer_id = '$cust_id'");
		
	foreach ($custDetails AS $customer);
	
	$custLocation = $myModel->customQuery("SELECT country.country_id, country.name as countryName, city.city_id, city.name as cityName FROM customer, country, city WHERE customer.customer_id = '$cust_id' AND customer.country_id = country.country_id AND customer.city_id = city.city_id");
	
	foreach($custLocation AS $custArea);
	
	$shipping = $myModel->customQuery("SELECT * FROM shipping_method WHERE status=1");
	$payment = $myModel->customQuery("SELECT * FROM payment_method WHERE status=1");
	
}else {
		
		header("Location:index.php");
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
        
        <div class="entry-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry-header">
                            <h1 class="entry-title"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- entry-header-area end -->

        <!-- checkout-area start -->
        <div class="checkout-area">
            <div class="container">
                <div class="row">
		<?php 
		if(isset($_POST['edit_address'])){
			if($_POST['country'] != 0 && $_POST['city'] != 0){				
				
				$columnValue["phone"] = $_POST['phone'];
				$columnValue["address"] = $_POST['address'];
				$columnValue["country_id"] = $_POST['country'];
				$columnValue["city_id"] = $_POST['city'];
				$columnValue["zipcode"] = $_POST['zipcode'];
							
			$xyz = $coreModel->updateData("customer", $columnValue, array("customer_id"=>$_SESSION['cust_id']));
			
			if($xyz > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully Updated Billing Address !
    				</div>';
						
						header("Refresh: 2; url = checkout.php");
						ob_end_flush();
					
    			}else{
					echo '
    				<div class="alert alert-danger fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					Billing Address has not been Updated !
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
				
				
                   <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-lg-5 col-md-5">
                            <div class="checkbox-form">
                                <div class="row">
                                <h3>Billing Address</h3>
                                      <div class="form-group ">
                                        <label class="control-label" for="name">Full Name <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input disabled class="form-control" id="name" name="name" value="<?php echo $customer['cust_name']; ?>" type="text"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-user">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="phone">Mobile <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" type="text" placeholder="Enter mobile number"/>
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
                                          <input required class="form-control" id="address" name="address" value="<?php echo $customer['address']; ?>" type="text" placeholder="Enter address" />
                                          <div class="input-group-addon">
                                          <i class="fa fa-location-arrow">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label" for="country">Country <span class="star">*</span>
                                        </label>
                                        <select required class="select form-control" id="country" name="country">
                                          <option value="">Select country</option>
							
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
                                          <input required class="form-control" id="zipcode" name="zipcode" value="<?php echo $customer['zipcode']; ?>" type="text" placeholder="Enter Zip Code"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-sort-numeric-desc">
                                          </i>
                                          </div>
                                        </div>
                                      </div>
									  
									  <div class="form-group">
                                        
                                         <button class="btn btn-danger" name="edit_address" type="submit"><i class="fa fa-paper-plane"></i> Update & Continue Order</button>
                                         
                                        
                                      </div><br>
                                   
                                </div>
								
                            </div>
                        </div>
					</form>
                        <div class="col-lg-7 col-md-7">
                            <div class="your-order">
                                <h3>Your order</h3>
                                
								<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
								<div class="your-order-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name" colspan="2"><strong>Product Description</strong></th>
                                                <th class="product-total"><strong>Total</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										
									<?php
									$subtotal = 0.00;
									foreach($_SESSION['cart'] as $key=>$product){ 
									$subtotal = $subtotal + $product['price'] * $product['quantity'];
									?>
                                            <tr class="cart_item">
                                                <td class="col-lg-1 col-md-1">
													<img src="secure/<?php echo $product['image']; ?>" alt="" />
												</td>
												<td class="product-name">
                                                    <?php echo $product['name']; ?> <strong class="product-quantity"> X <?php echo $product['quantity']; ?></strong>
                                                </td>
                                                <td class="product-total">
                                                    <span class="amount"><?php echo number_format($product['price']*$product['quantity'], 2, '.', ''); ?></span>
                                                </td>
                                            </tr>
									<?php } ?> 	                                            
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th colspan="2"><strong>Cart Subtotal</strong></th>
                                                <td><span class="amount"><strong><?php echo $sub_total = @$_SESSION['subtotal'] ? @$_SESSION['subtotal'] : 0.00; ?></strong></span></td>
                                            </tr>
											
											<?php if(@$_SESSION['coupon_amount'] > 0){ ?>
											<tr class="shipping">
                                                <th colspan="2"><strong>Coupon Discount</strong></th>
                                                <td>
                                                    <span class="amount"><strong><?php echo @$_SESSION['coupon_amount']; ?></strong></span>
                                                </td>
                                            </tr>
											<?php } ?>
											
                                            <tr class="shipping">
											  <?php if($sub_total < 2000){ ?>
                                                <th colspan="2"><strong>Shipping Charge</strong></th>
                                                <td>
                                                    <ul>
													<?php foreach($shipping as $sValue){ ?>
                                                        <li>
                                                            <input type="radio" required name="shipping_amount" value="<?php echo $sValue['amount']; ?>" onclick="setShipping(this.value)" />
                                                            
															<label>
                                                            <?php echo $sValue['title']; ?>:  <span class="amount"><strong> <?php echo $sValue['amount']; ?></strong></span>
															</label>
                                                        </li>
													<?php } ?>
                                                       
                                                    </ul>
                                                </td>
											  <?php } else{ ?>  
												<th colspan="2"><strong>Shipping Charge:</strong></th> 
												<td>0.00</td> 
												<input type="hidden" name="shipping_amount" value="0.00" />
											<?php } ?>
                                            </tr>
											
											
                                            <tr class="order-total">
                                                <th colspan="2"><strong>Order Total</strong></th>
												
												<span class="amount" id="grand_total" style="display:none"> <?php echo $sub_total-@$_SESSION['coupon_amount']; ?></span>
                                                
												<td><strong>BDT <span class="amount" id="grand_total_show"> <?php echo $sub_total-@$_SESSION['coupon_amount']; ?></span></strong>
                                                </td>
												
												<input type="hidden" name="amount" id="amount" value="<?php echo ($sub_total-@$_SESSION['coupon_amount']); ?>" />
													
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
								<?php } ?>
                                
								
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- checkout-area end -->

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>

    <?php include('views/footer-script.php'); ?>
	
</body>
</html>

