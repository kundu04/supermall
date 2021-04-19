<?php include ('views/header-script.php'); ?>
<?php include ('includeConfig/urlsession.php'); ?>
<?php
	if(isset($_GET['pro_id']) && $_GET['pro_id'] !=="" && isset($_SESSION['cust_id']) && $_SESSION['cust_id'] !=="" ){
		
		$pro_id = ceil($_GET['pro_id']);
		$cust_id = ceil($_SESSION['cust_id']);
		
		$stmt = $coreModel->insertData("customer_wishlist", array("customer_id"=>$cust_id, "product_id"=>$pro_id));
	}
	
	if(isset($_GET['remove'])){
		
		$product_id = $_GET['remove'];
		$custId = $_SESSION['cust_id'];
		
		$result = $coreModel->deleteData("customer_wishlist", array("customer_id"=>$custId, "product_id"=>$product_id));
	}
	
	if(isset($_SESSION['cust_id'])){
		
		$cust_id = $_SESSION['cust_id'];
			
		$wishLists = $myModel->customQuery("SELECT p.product_id, p.main_image, p.price, p.stock_status_id,  pd.name, cw.*, prd.price as dis_price FROM product as p
		LEFT JOIN product_description as pd ON p.product_id = pd.product_id
		LEFT JOIN product_discount as prd ON p.product_id = prd.product_id 
		LEFT JOIN customer_wishlist as cw ON p.product_id = cw.product_id 	
		WHERE cw.customer_id = '$cust_id ' ");
	
	} else {
		
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
                        <div class="entry-header">
                            <h1 class="entry-title">Wishlist</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- entry-header-area end -->

        <!-- wishlist-area start -->
        <div class="wishlist-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <?php if($wishLists){ ?>
										
										<thead style="background-color:#F5F5F5">
                                            <tr>
                                                <th class="product-price">Sl No</th>
												<th class="product-thumbnail">Image</th>
                                                <th class="product-name"><span class="nobr">Product Name</span></th>
                                                <th class="product-price"><span class="nobr"> Unit Price </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Stock Status </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">add-to-cart </span></th>
												<th class="product-remove"><span class="nobr">Remove</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
																				
											<?php
											foreach($wishLists as $key => $wishList){ ?>
                                            
											<tr>
                                                <td class="product-price"><?php echo ($key+1); ?></td>
												<td class="product-thumbnail">
                                                    <a href="product-details.php?product_id=<?php echo $wishList['product_id']; ?>"><img src="secure/<?php echo $wishList['main_image']; ?>" alt="" /></a>
                                                </td>
                                                <td class="product-name"><a href="product-details.php?product_id=<?php echo $wishList['product_id']; ?>"><?php echo $wishList['name']; ?></a></td>
                                                <td class="product-price">
												<span class="amount">
												 
												<?php if(isset($wishList['dis_price']) && $wishList['dis_price']>0){
													
															echo $wishList['dis_price'];	
												
												} else {
													echo $wishList['price'];
												}?>
												
												</span>
												</td>
                                                
												<td class="product-stock-status">
													<span class="wishlist-in-stock">
													<?php												
													$stock_id = $wishList['stock_status_id'];
													
													$stmt = $myModel->customQuery("SELECT stock_name FROM stock_status
													WHERE stock_status_id = '$stock_id'");
													echo $stmt[0]['stock_name'];
													?>
													</span>
												</td>
                                                
												<?php
												$id = $wishList['product_id'];
													
												$stmtC = $myModel->customQuery("SELECT * FROM product_color WHERE product_id = $id");
													
												$stmtS = $myModel->customQuery("SELECT * FROM product_size WHERE product_id = $id");
												
												if(isset($wishList['dis_price']) && $wishList['dis_price']>0){ 
                                                                
												$price = $wishList['dis_price'];
												}else{
													$price = $wishList['price']; 
												}
													
												if(count($stmtC) > 0 || count($stmtS) > 0 ){ ?>
													
												<td class="product-add-to-cart"><a product-id="<?php echo $wishList['product_id'];?>" data-toggle="modal" data-target="#cartpopup"  title="add-to-cart" class="add-to-cart cartpopup modal-view detail-link" href="#">Add to Cart</a></td>
														
												<?php } else { ?>
													
												<td class="product-add-to-cart">
												
												<a href="javascript:void(0)" onclick="addToCart(<?php echo $wishList['product_id'];?>, 1, <?php echo $price; ?>)">Add to Cart</a>
												
												</td>
													
												<?php } ?>
												
												<td class="product-remove"><a title="Remove"  
												href="?remove=<?php echo $wishList['product_id']; ?>">×</a></td>
												
                                           </tr>									
											<?php } ?>
											
												
                                        </tbody>
										<?php } else { ?>
											<tr>
												<td colspan="7"><center><h3>NO Product in your Wishlist</h3></center></td>
											</tr>
										<?php } ?>
										
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Share on:</h4>
                                                        <ul>
                                                            <li>
                                                                <a class="facebook" href="#"></a>
                                                            </li>
                                                            <li>
                                                                <a class="twitter" href="#"></a>
                                                            </li>
                                                            <li>
                                                                <a class="pinterest" href="#"></a>
                                                            </li>
                                                            <li>
                                                                <a class="googleplus" href="#"></a>
                                                            </li>
                                                            <li>
                                                                <a class="email" href="#"></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->
        
        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
		 <?php include('views/quick-view.php') ?>
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>

    <?php include('views/footer-script.php'); ?>
</body>
</html>