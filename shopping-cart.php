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
        
        <!-- entry-header-area start -->
        <div class="entry-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry-header">
                            <h1 class="entry-title">Shopping Cart</h1>
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
                        <form action="#" id="frm_cart">
                            <div id="shop-cart-body">
							
							<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
							
							<div class="table-content table-responsive">
                                <table>
                               		<thead style="background-color:#F5F5F5">
                                        <tr>
                                            <th class="product-sl">Sl. No.</th>
											<th class="product-thumbnail">Image</th>
                                            <th class="product-name">Product Name</th>
                                            <th class="product-color">Color / Size</th>
                                            <th class="product-price">Unit Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
									<?php
									$subtotal = 0.00; $sl = 0;
									foreach($_SESSION['cart'] as $key=>$product){ 
									$subtotal = $subtotal + $product['price'] * $product['quantity'];
									 $sl++;
									?>
									
									<tr>
										<td class="product-sl"><?php echo $sl; ?></td>
										<td class="product-thumbnail">
											<a href="product-details.php?product_id=<?php echo $product['pid']; ?>"><img src="secure/<?php echo $product['image']; ?>" alt="" /></a>
										</td>
										
										<td class="product-name"><a href="product-details.php?product_id=<?php echo $product['pid']; ?>"><?php echo $product['name']; ?></a></td>
										
										<td class="product-color"><span style="font-weight: bold"><?php echo $product['color']; ?><br><br><br><?php echo $product['size']; ?></span></td>
										
										<td class="product-price"><span class="amount" id="amount<?php echo $product['pid']; ?>"><?php echo number_format($product['price'], 2, '.', ''); ?></span></td>
										
										<td class="product-quantity">
											<input type="number" id="qnt<?php echo $product['pid']; ?>" name="upQty[<?php echo $product['pid']; ?>]" value="<?php echo $product['quantity']; ?>" min="1" onkeyup="setSum(<?php echo $product['pid']; ?>)" />
											
										</td>
										
										<td class="product-subtotal" id="subtotal<?php echo $product['pid']; ?>"><?php echo number_format($product['price']*$product['quantity'], 2, '.', ''); ?></td>
										
										<td class="product-remove"><a href="javascript:void(0)" onclick="removeCart(<?php echo $key; ?>)"><i class="fa fa-times"></i></a>
										</td>	
										
                                    </tr>
									
                                    <?php  } ?>    
										
                                    </tbody>
									
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <div class="buttons-cart">
                                        <a href="shopping.php?cat_id=1">Continue Shopping</a>
										<input type="button" value="UpdateCart" onclick="update_cart()" />
                                        
                                    </div>
                                    <div class="coupon">
                                        <h3><strong>Coupon</strong></h3>
                                        <p>Enter your coupon code if you have one.</p>
                                        <input type="text" id="coupon_code" placeholder="Coupon code" />
										<div class="buttons-cart">
											<input type="button" value="Apply Coupon" onclick="getCoupon()" />
											<p><span id="coupon_msg"></span></p>
										</div>
										
                                    </div>
									
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <h2>Cart Totals</h2>
                                        <table>
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Subtotal</th>
                                                    <td><label><span class="amount" id="mini-cart-subtotal-cartpage"><?php echo @$_SESSION['subtotal'] ? @$_SESSION['subtotal'] : 0.00; ?></span></label></td>
                                                </tr>
												
												<tr class="cart-subtotal">
                                                    <th>Coupon Discount</th>
                                                    <td><label><span class="amount" id="coupon_amount"> 0.00</span> </label></td>
                                                </tr>
                                                									
                                                <tr class="order-total">
                                                    <th>Grand Total</th>
                                                    <td>
                                                        <strong><span class="amount">BDT <span id="grand_total"><?php echo @$_SESSION['subtotal'] ? @$_SESSION['subtotal'] : 0.00; ?></span></span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="wc-proceed-to-checkout">
                                            <a href="checkout.php">Proceed to Checkout</a><br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php } else { ?>
							<div class="table-content table-responsive">
                                <table>
									<tbody>
										<tr>
											<td colspan="7"><center><h2>NO Product in your Shopping Cart</h2></center></td>
										</tr>
								   </tbody>
								</table>
							</div>                                
							<?php } ?>
							
							</div>
                        </form>
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