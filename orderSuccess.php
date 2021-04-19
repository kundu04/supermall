<?php 
include ('views/header-script.php');
include_once("SSLCOMMERZ/SSLCZConfig.php"); 
include_once "SSLCOMMERZ/SSLCommerz.php";
$sslc = new SSLCommerz();

$order_id = @$_POST['tran_id'];
$payment_status = @$_POST['status'];

if($payment_status=='VALID'){
	
$data = $coreModel->updateData("order", array("order_status_id"=>2), array("order_id"=>$order_id));	
	
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
                            <h1 class="entry-title">Order Success</h1>
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
								<tbody>
									<tr>
										<td colspan="7">
											<center><h2>Thank You for your order.</h2></center>
										</td>
									</tr>
								</tbody>
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

    <?php include('views/footer-script.php'); 
unset($_SESSION['cart']);
unset($_SESSION['coupon_amount']);
unset($_SESSION['items']);
unset($_SESSION['subtotal']);
	
	?>
</body>
</html>