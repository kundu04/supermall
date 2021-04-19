<?php include("config.php") ?>
<?php

$proQnt = $_POST['upQty'];
foreach($proQnt as $key=>$value){
	
$_SESSION['cart'][$key]['quantity']	 = $value;

}

?>
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
                  <button><span>Checkout</span></button>
           </div>
<?php

$_SESSION['subtotal'] = number_format($subtotal, 2, '.', ''); 
$_SESSION['items'] = count($_SESSION['cart']);

 ?>
