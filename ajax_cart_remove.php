<?php include("config.php") ?>
<?php
$product_id = $_REQUEST['proId'];

if(!empty($product_id)){
	
	unset($_SESSION['cart'][$product_id]);
	
}

?>
                             
	<?php if(!empty($_SESSION['cart'])){ ?>
       <div><Span style="font-size:16px">Recently added items</span></div><br>
            <ol class="mini-products-list">
                <!-- single item -->
				
				<?php
                    $subtotal = 0;
					foreach($_SESSION['cart'] as $key=>$product){ 
					$subtotal = $subtotal + $product['price'] * $product['quantity'];
				?>
                <li>
                    <a class="product-image" href="product-details.php?product_id=<?php echo $product['pid']; ?>">
                           <img alt="" src="secure/<?php echo $product['image'];  ?>">
                    </a>
                    <div class="product-details">
                       <p class="cartproduct-name">
                          <a href="product-details.php?product_id=<?php echo $product['pid'];?>"><?php echo $product['name'];  ?> </a>
                       </p>
                       <strong class="qty">Qty: <?php echo $product['quantity'];  ?></strong>
                       <span class="sig-price">BDT <?php echo number_format($product['price'], 2, '.', '');  ?></span>
                   </div>
                   <div class="pro-action">
                       <a class="btn-remove" href="javascript:void(0)" onclick="removeCart(<?php echo $key; ?>)">remove</a>
                   </div>
               </li>
               <?php } ?>
           </ol>
           <div class="top-subtotal">
                 Subtotal: <span class="sig-price">BDT <?php echo number_format($subtotal, 2, '.', ''); ?></span>
           </div>
           <div class="cart-actions">
				<a class="btn btn-danger floatleft" style="padding:6px 16px; font-size:15px;" href="shopping-cart.php">Go  Cart</a>								
				<a class="btn btn-danger floatright" style="padding:6px 16px; font-size:15px;" href="checkout.php"> Checkout</a>
           </div>
 <?php 
	 $_SESSION['subtotal'] = number_format($subtotal, 2, '.', ''); 
     $_SESSION['items'] = count($_SESSION['cart']);
 } else{ ?> <p> There are no items in the cart.</p><?php
     $_SESSION['subtotal'] = 0.00; 
     $_SESSION['items'] = 0;
 } ?>
 

