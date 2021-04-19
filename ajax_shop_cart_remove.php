<?php include("config.php") ?>
<?php
$product_id = $_REQUEST['proId'];

if(!empty($product_id)){
	
	unset($_SESSION['cart'][$product_id]);	

}

?>
                             
	<?php if(!empty($_SESSION['cart'])) { ?>
							
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
					<input type="text" placeholder="Coupon code" />
					<input type="submit" value="Apply Coupon" />
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
								<td><label><span class="amount"> 0.00</span> </label></td>
							</tr>
                            												
							<tr class="order-total">
								<th>Grand Total</th>
								<td>
									<strong><span class="amount">BDT 215.00</span></strong>
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
	<?php 
	$_SESSION['subtotal'] = 0.00;
	$_SESSION['items'] = 0;	
	} ?>
 
