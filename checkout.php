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
	
	if($customer['phone'] =='' || $customer['address'] =='' || $customer['country_id'] =='' || $customer['city_id'] =='' || $customer['zipcode'] ==''){
		
		header("Location:billing-address.php");	
	}
		
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
                            <h1 class="entry-title">Checkout</h1>
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
                   <form action="orderProcess.php" method="post" enctype="multipart/form-data">
                        <div class="col-lg-5 col-md-5">
                            <div class="checkbox-form">
                                <h3>Delivery Address</h3>
								<div class=" row">
									<label>
										<input type="radio" name="shipping_address" value="existing" />
										<p class="btn btn-primary">Ship to Billing address</p>
									</label>
								
									<label>
										<input type="radio" name="shipping_address" value="new" />
										<p class="btn btn-success" >Ship to different address</p>
									</label>
								</div><br><br>
								
								<div class="row">
								
									<div id="addresstoggle"></div>
                                
								</div>
                               
                            </div>
                        </div>
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
                                                <td class="col-lg-1 col-md-1 col-sm-1">
													<img src="secure/<?php echo $product['image']; ?>" alt="" width="100" />
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
												<?php $total_amount = $sub_total-@$_SESSION['coupon_amount']; ?>
												<input type="hidden" name="amount" id="amount_1" value="<?php echo $total_amount; ?>" />
													
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
								<?php } ?>
                                
								<div class="payment-method">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">Payment Method</h4>
										</div>
                                            
										<div class="panel-body">
											<tr class="shipping">
												<ul>
													<?php foreach($payment as $pValue){ ?>
													<li>
														<input type="radio" name="payment_method" value="<?php echo $pValue['code']; ?>" required />
														<label><span>
                                                            <?php echo $pValue['title']; ?></span>
                                                        </label><br/><br/>
													</li>
													<?php } ?>    
												</ul>
                                              </tr>  
										</div>    
									</div>
                                        
                                    <div class="order-button-payment">
                                        <input type="submit" name="order" value="Place order" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

<script type="text/javascript">

// $('input[name=\'shipping_address\']').on('change', function() {
	
	// if (this.value == 'new') {
		
		// $('#shipping-new').slideDown('slow');
				
	// } else {
		
		// $('#shipping-new').slideUp('slow');
	// }
// });



$('input[name=\'shipping_address\']').on('change', function() {
            
	if (this.value == 'new') {
		var ship = 'new';
		
	} else {
		
		var ship = 'existing';
	}
    $.ajax({
		type: "GET",
		url: "ajax_address.php",
		data:{get_ship_address:ship}
		}).done(function(data){
			$("#addresstoggle").html(data);
		});
});

</script>

	
</body>
</html>

