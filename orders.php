<?php include ('views/header-script.php'); ?>
<?php include ('includeConfig/urlsession.php'); ?>
<?php
	if(isset($_SESSION['cust_id']) && $_SESSION['cust_id'] !=="" ){
		
		$cust_id = $_SESSION['cust_id'];
			
		$orderLists = $myModel->customQuery("SELECT o.order_id, o.total_amount, o.order_status_id, o.date_added, oS.name as status FROM `order` as o, order_status as oS 
		WHERE o.customer_id = '$cust_id' AND o.order_status_id = oS.order_status_id");
	
	}else{	
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
        
        <!-- entry-header-area start -->
        <div class="entry-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry-header"><br>
                            <h1 class="entry-title">Order History</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- entry-header-area end -->
        <!-- cart-main-area start -->
        <div class="cart-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-content table-responsive">
                            <table>
							 <?php if(!empty($orderLists[0]['order_id'])){ ?>
                                <thead style="background-color:#F5F5F5">
                                    <tr>
                                        <th class="product-sl">Order No.</th>
                                        <th class="product-name">Customer Name</th>
                                        <th class="product-quantity">No. of Product</th>
                                        <th class="product-subtotal">Total Price</th>
                                        <th class="product-subtotal">Status</th>
										<th class="product-subtotal">Date Added</th>
                                        <th class="product-remove">View Order</th>
                                    </tr>
                                </thead>
                                <tbody>
							<?php foreach($orderLists as $key => $orderList){ ?>
                                    <tr>
                                        <td class="product-sl"><?php echo ($key+1); ?></td>
                                        <td class="product-name"><a href="#"><?php echo $_SESSION['cust_name']; ?></a></td>
                            
							<?php 	
								$oId = $orderList['order_id'];
								$no_of_product = $myModel->customQuery("SELECT count(*) as total_p FROM `order_product` as oP WHERE oP.order_id = '$oId'"); 
							?>            
                                        <td class="product-subtotal">
											<?php echo $no_of_product[0]['total_p']; ?>				
										</td>
                                        <td class="product-subtotal"><?php echo $orderList['total_amount']; ?></td>
                                        <td class="product-subtotal"><?php echo $orderList['status']; ?></td>
										<td class="product-subtotal"><?php echo $orderList['date_added']; ?></td>
                                        <td class="product-remove"><a title="View" href="#"><i class="fa fa-eye"></i></a></td>
                                    </tr>
							<?php } ?> 
							
                                </tbody>
								
							<?php } else { ?>
									<tr>
										<td colspan="7"><center><h3>You did not place any order yet !</h3></center></td>
									</tr>
							
							<?php } ?>
                            
							</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>

    <?php include('views/footer-script.php'); ?>
</body>
</html>