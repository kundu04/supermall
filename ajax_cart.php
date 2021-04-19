<?php include("config.php") ?>
<?php
$product_id = $_REQUEST['proId'];
$quantity = $_REQUEST['qnt'];
$colorID = $_REQUEST['colorID'];
$sizeID = $_REQUEST['sizeID'];
$price = $_REQUEST['price'];

$product = $myModel->customQuery("SELECT p.*,pd.* FROM product as p
left join product_description as pd ON p.product_id = pd.product_id
WHERE  p.product_id = '$product_id' AND p.quantity >= '$quantity' AND p.price > 0 LIMIT 1");


$color = $myModel->customQuery("SELECT color.color_name FROM color WHERE color_id = '$colorID' LIMIT 1"); 
$size = $myModel->customQuery("SELECT size.size_name FROM size WHERE size_id = '$sizeID' LIMIT 1");


if(!empty($product)){
	
	$_SESSION['cart'][$product_id] = array('pid'=>$product[0]['product_id'], 'name'=>$product[0]['name'], 'price'=>$price, 'quantity'=>$quantity,  'image'=>$product[0]['main_image'], 'color'=>@$color[0]['color_name'], 'size'=>@$size[0]['size_name']);
	
	$mgs = "Successfully added";
}
else{
	
   $mgs = "This amount of quantity are not avaibile"; 
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
				<a class="btn btn-danger floatleft" style="padding:6px 16px; font-size:15px;" href="shopping-cart.php">Go  Cart</a>						
				<a class="btn btn-danger floatright" style="padding:6px 16px; font-size:15px;" href="checkout.php"> Checkout</a>
           </div>
<?php

$_SESSION['subtotal'] = number_format($subtotal, 2, '.', ''); 
$_SESSION['items'] = count($_SESSION['cart']);

 ?>
