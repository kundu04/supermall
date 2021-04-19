<div class="main-menu-area">
    <div class="mainmenu">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-9 hidden-sm hidden-xs ">
                    <nav class="header-menu">
                        <ul class="clearfix">
                            <li class="first page-active"><a href="index.php">Home</a>

                            </li>

                            <?php 
                            foreach ($queryResult AS $catList){
                            ?>
                            <li><a href="shopping.php?cat_id=<?php echo $catList["category_id"];?>"><?php echo $catList["cat_name"];?></a>

                                <div class="megamenu-wrap four-column">
                                
                                    <?php 
                                    $parentValue['parent_id'] = $catList["category_id"];
                                    $stmt = $coreModel->selectData("*", "category", $parentValue);
                                    foreach($stmt as $subList) {
                                    ?>
                                    <ul class="mega-child">
                                        <li><a class="mega-menu-title" href="shopping.php?cat_id=<?php echo $subList["category_id"];?>"><?php echo $subList['cat_name']; ?></a>
                                        </li>
                                        
                                        <?php 
                                        $parentValue_1['parent_id'] = $subList["category_id"];
                                        $stmt_1 = $coreModel->selectData("*", "category", $parentValue_1);
                                        foreach($stmt_1 as $subsubList) {
                                        ?>
                                        <li><a href="shopping.php?cat_id=<?php echo $subsubList["category_id"];?>"><?php echo $subsubList['cat_name']; ?></a>
                                        </li>
                                        <?php } ?>
                                                                             
                                    </ul>
                                    <?php } ?>  
                                
                                </div>

                            </li>
                            <?php } ?>
                            
                            <li><a href="contact.php">Contact</a></li>
                        
                        </ul>
                    </nav>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="add-to-cart-area">
                        <div class="top-cart-wrapper style-one">
                            <div class="block-cart">
                            <span class="cart-icon"><i class="fa fa-cart-arrow-down"></i></span>
                                <div class="top-cart-title">
                                    <a href="shopping-cart.php">
                                        <span class="title-cart">Shopping cart</span>
                                        <span class="count-item"><span id="mini-cart-items"><?php echo @$_SESSION['items'] ? @$_SESSION['items'] : 0; ?></span> items</span>
                                        <span class="price">BDT <span id="mini-cart-subtotal"><?php echo @$_SESSION['subtotal'] ? @$_SESSION['subtotal'] : 0.00; ?></span></span>
                                    </a>
                                </div>
                                <div class="top-cart-content" id="mini-cart-body">
								<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                                <div><Span style="font-size:16px">Recently added items</span></div><br>  
									<ol class="mini-products-list">
									
                                        <!-- single item -->
										<?php
                                        $subtotal = 0.00;
										foreach($_SESSION['cart'] as $key=>$product){ 
										$subtotal = $subtotal + $product['price'] * $product['quantity'];
										?>
                                        <li>
                                            <a class="product-image" href="product-details.php?product_id=<?php echo $product['pid']; ?>">
                                                <img alt="" src="secure/<?php echo $product['image'];  ?>">
                                            </a>
                                            <div class="product-details">
                                                <p class="cartproduct-name">
                                                    <a href="product-details.php?product_id=<?php echo $product['pid']; ?>"><?php echo $product['name'];  ?> </a>
                                                </p>
                                                <strong class="qty">Qty: <?php echo $product['quantity'];  ?></strong>
                                                <span class="sig-price">BDT <?php echo $product['price'];  ?></span>
                                            </div>
                                            <div class="pro-action">
                                                <a class="btn-remove" href="javascript:void(0)" onclick="removeCart(<?php echo $key; ?>)">remove</a>
                                            </div>
                                        </li>
                                       <?php } ?>
                                    </ol>
                                    <div class="top-subtotal">
                                        Subtotal: <span class="sig-price">BDT <?php echo $subtotal; ?></span>
                                    </div>
                                    <div class="cart-actions">
                                        
										<a class="btn btn-danger floatleft" style="padding:6px 16px; font-size:15px;" href="shopping-cart.php">Go  Cart</a>
										
										<a class="btn btn-danger floatright" style="padding:6px 16px; font-size:15px;" href="checkout.php"> Checkout</a>
                        			
									</div>
								   <?php } else { ?>
								   <p>There are no items in your cart.</p>
								   <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>