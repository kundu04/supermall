<?php include ('views/header-script.php'); ?>
<?php include ('includeConfig/urlsession.php'); ?>
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
        
        <!-- Start Slider area -->
        <?php include('views/slider.php') ?>
        <!-- End Slider area -->
		
		<!-- Banner area-2 -->
		<?php 
		$banner = $coreModel->selectData('*', 'banner', array('status' => 'Active','position' => 'home footer'));
		$banner1 = $banner[0]['image'];
		$banner2 = $banner[1]['image'];
        $sidebanner = $coreModel->selectData('*', 'banner', array('status' => 'Active','position' => 'home sidebar'));
        $sidebanner1 = $sidebanner[0]['image'];
		?>

		<!-- Special products query -->
        <?php 
        $sProducts1 = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product_discount as prd left join product_description as pd ON prd.product_id = pd.product_id left join product as p ON prd.product_id = p.product_id WHERE prd.price > 0 AND p.status='Active' ORDER BY prd.product_id DESC");
        $total_product = count($sProducts1);
        ?>
		
		<!-- Most viewed products query -->
        <?php 
        $vProducts1 = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product_discount as prd left join product_description as pd ON prd.product_id = pd.product_id left join product as p ON prd.product_id = p.product_id 
		WHERE p.status='Active' ORDER BY p.viewed DESC LIMIT 9");
        $total_vproduct = count($vProducts1);
        ?>
		
		<!-- Best seller products query -->		
		<?php 
        $bProducts1 = $myModel->customQuery("SELECT p.main_image, p.price, pd.product_id, pd.name, prd.price as dis_price, count(p.product_id) as bestSell FROM order_product as op 
		left join product_description as pd ON op.product_id = pd.product_id 
		left join product as p ON op.product_id = p.product_id 
		left join product_discount as prd ON op.product_id = prd.product_id
		WHERE p.status='Active' GROUP BY op.product_id ORDER BY bestsell DESC LIMIT 20");
        $total_bproduct = count($bProducts1);
        ?>
		
		<!-- Start page content -->
        <section class="page-content">
            <div class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3">
                            <!-- Start single-product -->
                            <div class="hot-deals-area">
                                <div class="section-title">
                                    <h2>Special Offers</h2>
                                </div>
								<div class="custom-row">
									<div class="bestseller-active-home-3 indicator-style-1">
                                            <!-- start product group -->
                                         
                                    <?php foreach($sProducts1 as $key=>$sProduct1){ 
                                          $sproductname1 = explode(' ', $sProduct1['name']);
                                                   
                                          $i = $key%4;
                                          $j = ($key+1) % 4;  
                                          if($i=='0'){
                                    ?> 
                                        <div class="col-md-12">
                                                 <?php } ?>
                                      
                                            <div class="tab-single-item">
                                                <div class="images-container">
                                                    <a class="pro-img" href="product-details.php?product_id=<?php echo $sProduct1['product_id']; ?>"><img src="secure/<?php echo $sProduct1['main_image']; ?>" alt="<?php echo $sProduct1['name']; ?>"></a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="product-details.php?product_id=<?php echo $sProduct1['product_id']; ?>"><?php echo @$sproductname1[0].' '.@$sproductname1[1]; ?></a></h2>
                                                    <div class="price-box">
                                                        <?php
                                                            if(isset($sProduct1['dis_price']) && $sProduct1['dis_price']>0){ ?> 
                                                            <span class="price">BDT <?php echo $sProduct1['dis_price'];?> </span>
                                                        <?php } ?>
                                                                        
                                                            <span class="price" <?php if(isset($sProduct1['dis_price']) && $sProduct1['dis_price']>0){
                                                                ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $sProduct1['price'];?>
                                                            </span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                           <?php if(($j=='0' && $key > 0) || $key+1==$total_product ){ ?>
                                        </div>

                                        <?php 
                                                } 
                                            }
                                        ?>  
                                            <!-- end product group -->    
                                    </div>
                                </div>
                            </div>
                            <!-- Start testimonial-area -->
                            <div class="testimonial-sidebar test-mt">
                                <div class="modul-title2 modul-title-style-1">
                                    <h2>Hot Product</h2>
                                </div>
                                <div class="testimonial-content-owl indicator-style-1">
                                    <div class="testimonial-content">
                                        <div class="testimonial-list">
                                            <div class="testimonial-sidebar-content">
                                                <div class="content">
                                                   
                                                    <img src="secure/<?php echo $sidebanner1;?>" alt="">
                                                                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-list">
                                            <div class="testimonial-sidebar-content">
                                                <div class="content">
                                                    
                                                    <img src="secure/<?php echo $sidebanner1;?>" alt="">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-list">
                                            <div class="testimonial-sidebar-content">
                                                <div class="content">
                                                    
                                                    <img src="secure/<?php echo $sidebanner1;?>" alt="">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end testimonial-area -->
                            <!-- start producttabs-area -->
                            <!-- Nav tabs -->
                            <div class="tab-container clearfix">
                                <ul class="tab-menu" role="tablist">
                                    <li role="presentation" class="active"><a href="#Most-Viewed" aria-controls="Most-Viewed" role="tab" data-toggle="tab">Most Viewed</a></li>
                                    <!--
									<li role="presentation"><a href="#Random" aria-controls="Random" role="tab" data-toggle="tab">Top reviewed</a></li>
									-->
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active fade in" id="Most-Viewed">
									<div class="custom-row">
										<div class="tab-container-list-owl">
											
										<?php foreach($vProducts1 as $key=>$vProduct1){ 
											$vproductname1 = explode(' ', $vProduct1['name']);
                                                   
											$i = $key%3;
											$j = ($key+1) % 3;  
											if($i=='0'){
										?>					
											<div class="tab-product-group">
												
												<?php } ?>	
												
												<div class="tab-single-item">
													<div class="images-container">
														<a class="pro-img" href="product-details.php?product_id=<?php echo $vProduct1['product_id']; ?>">
															<img src="secure/<?php echo $vProduct1['main_image']; ?>" alt="<?php echo $vProduct1['name']; ?>">
														</a>
													</div>
													<div class="des-container">
														<h2 class="product-name"><a href="product-details.php?product_id=<?php echo $vProduct1['product_id']; ?>"><?php echo @$vproductname1[0].' '.@$vproductname1[1]; ?></a></h2>
														<div class="price-box">
                                                        <?php
                                                            if(isset($vProduct1['dis_price']) && $vProduct1['dis_price']>0){ ?> 
                                                            <span class="price">BDT <?php echo $vProduct1['dis_price'];?> </span>
                                                        <?php } ?>
                                                                        
                                                            <span class="price" <?php if(isset($vProduct1['dis_price']) && $vProduct1['dis_price']>0){
                                                                ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $vProduct1['price'];?>
                                                            </span>
                                                    </div>
														<div class="rating">
															<ul>
																<li class="yes"><i class="fa fa-star-half-o"></i></li>
																<li class="yes"><i class="fa fa-star-half-o"></i></li>
																<li class="yes"><i class="fa fa-star-half-o"></i></li>
																<li class="yes"><i class="fa fa-star-half-o"></i></li>
																<li><i class="fa fa-star-half-o"></i></li>
															</ul>
														</div>
													</div>
												</div>
												
												<?php if(($j=='0' && $key > 0) || $key+1==$total_vproduct ){ ?>
												
											</div>
											
											<?php 
													} 
												}
											?> 										
											
										</div>
									</div>
                                </div>
                                <!--
								<div role="tabpanel" class="tab-pane fade in" id="Random">
                                    <div class="tab-container-list-owl">
                                        <div class="tab-product-group">
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/7.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/7.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item hidden-md">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/1.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-product-group">
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/10_1.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/13_2.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item hidden-md">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/23_2.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-product-group">
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/23_2.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item">
                                                <div class="images-container clearfix">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/2_1.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                        <span class="old-price">$333.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-single-item hidden-md">
                                                <div class="images-container">
                                                    <a class="pro-img" href="#">
                                                        <img src="img/product/tab-product/6.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name"><a href="single-product.php">voluptas nulla</a></h2>
                                                    <div class="price-box">
                                                        <span class="new-price">$222.00</span>
                                                    </div>
                                                    <div class="rating">
                                                        <ul>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                            <li><i class="fa fa-star-half-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>

                            <!--end Nav tabs -->

                            <!-- end producttabs-area -->
                        </div>
                        <!-- end single-product -->

                        <!-- Start feature products -->
                        <?php $fProducts = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product as p
                        left join product_description as pd ON p.product_id = pd.product_id
                        left join product_discount as prd ON  p.product_id = prd.product_id WHERE  p.type = 'Featured' AND p.status='Active' ORDER BY p.product_id DESC limit 10");?>
                        
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                           <!-- start feature area -->
                            <div class="bestsellerproductslider-area">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ma-bestsellerproductslider-container">
                                            <div class="modul-title modul-title-style-1">
                                                <h2>Featured Products</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="featured-area">
                                    <div class="row">
                                        <!-- start-product-owl-area-2 -->
                                        <div class="bestseller-owl-active indicator-style-1">
                                            <!-- start banner-area-2 -->
                                            <?php foreach($fProducts as $product){ ?>
                                            <div class="col-md-4">
                                                <div class="single-product">
                                                    <div class="item-inner">
                                                        <div class="img-container">
                                                            <a class="product-image" href="product-details.php?product_id=<?php echo $product['product_id']; ?>"><img src="secure/<?php echo $product['main_image']; ?>"></a>
                                                            <div class="actions">
                                                                
																<?php
																$id = $product['product_id'];
																	
																$stmtC = $myModel->customQuery("SELECT * FROM product_color
																WHERE product_id = $id");
																	
																$stmtS = $myModel->customQuery("SELECT * FROM product_size
																WHERE product_id = $id");
																
																
                                                                if(isset($product['dis_price']) && $product['dis_price']>0){ 
                                                                
																	$price = $product['dis_price'];
																}else{
																	$price = $product['price']; 
																} 
																	
																if(count($stmtC) > 0 || count($stmtS) > 0 ){ ?>
																	
																	<a product-id="<?php echo $product['product_id'];?>" data-toggle="modal" data-target="#cartpopup"  title="add-to-cart" class="add-to-cart cartpopup modal-view detail-link" href="#"></a>
																		
																<?php } else { ?>
																	
																	<a data-toggle="tooltip" title="add-to-cart" class="add-to-cart" href="javascript:void(0)" onclick="addToCart(<?php echo $product['product_id'];?>, 1, <?php echo $price; ?>)"></a>
																	
																<?php } ?>
                                                                
														
																	<a data-toggle="tooltip" title="wishlist" pro="<?php echo $product['product_id'];?>" class="wishlist addwishlist" 
																	href="javascript:void(0)"></a>
																	
                                                                
																<a data-toggle="tooltip" title="compare" class="compare" href="#"></a>
                                                                <a title="quick-view" product-id="<?php echo $product['product_id'];?>" data-toggle="modal" data-target="#productModal" class="q_view quick-view modal-view detail-link" href="#"></a>
                                                            </div>
                                                        </div>
                                                        <div class="des-container">
                                                            <h2 class="product-name">
                                                            <a title="Product details" href="product-details.php?product_id=<?php echo $product['product_id']; ?>"> <?php echo $product['name']; ?> </a>
                                                            </h2>
                                                            <div class="price-box">
                                                                <?php
                                                                if(isset($product['dis_price']) && $product['dis_price']>0){ ?> 
                                                                <span class="price">BDT <?php echo $product['dis_price'];?> </span>
                                                                <?php } ?>
                                                                        
                                                                <span class="price" <?php if(isset($product['dis_price']) && $product['dis_price']>0){
                                                                   ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $product['price'];?>
                                                                </span>
                                                              
                                                            </div>
                                                            <div class="ratings">
                                                                <div class="rating-box">
                                                                    <ul>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li><i class="fa fa-star-half-o"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            
                                            <!-- end-product-area-2 -->
                                        </div>
                                        <!-- end-product-owl-area-2 -->
                                    </div>
                                </div>
                            </div>
                            <!--end feature-area  -->
                            <!-- start bestsellerproducts-area -->
                            <div class="bestsellerproductslider-area mts-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ma-bestsellerproductslider-container">
                                            <div class="modul-title modul-title-style-1">
                                                <h2>Best sellers</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bestsellerproductslider-item">
                                    <div class="row">
                                        <div class="bestseller-owl-active indicator-style-1">
                                            <!-- start product group -->
                                         <?php foreach($bProducts1 as $key=>$bProduct1){ 
                                                   
											$i = $key%2;
											$j = ($key+1) % 2;  
											if($i=='0'){
										?>   
											
											<div class="col-md-4">
                                                
											<?php } ?>	
												<!-- start single product -->
                                                <div class="single-product">
                                                    <div class="item-inner">
                                                        <div class="img-container">
                                                            <a class="product-image" href="product-details.php?product_id=<?php echo $bProduct1['product_id']; ?>"><img src="secure/<?php echo $bProduct1['main_image']; ?>"></a>
                                                            <div class="actions">
                                                                
																<?php
																$id = $bProduct1['product_id'];
																	
																$stmtC = $myModel->customQuery("SELECT * FROM product_color
																WHERE product_id = $id");
																	
																$stmtS = $myModel->customQuery("SELECT * FROM product_size
																WHERE product_id = $id");
																
																
                                                                if(isset($bProduct1['dis_price']) && $bProduct1['dis_price']>0){ 
                                                                
																	$price = $bProduct1['dis_price'];
																}else{
																	$price = $bProduct1['price']; 
																} 
																	
																if(count($stmtC) > 0 || count($stmtS) > 0 ){ ?>
																	
																	<a product-id="<?php echo $bProduct1['product_id'];?>" data-toggle="modal" data-target="#cartpopup"  title="add-to-cart" class="add-to-cart cartpopup modal-view detail-link" href="#"></a>
																		
																<?php } else { ?>
																	
																	<a data-toggle="tooltip" title="add-to-cart" class="add-to-cart" href="javascript:void(0)" onclick="addToCart(<?php echo $bProduct1['product_id'];?>, 1, <?php echo $price; ?>)"></a>
																	
																<?php } ?>
                                                                
														
																	<a data-toggle="tooltip" title="wishlist" pro="<?php echo $bProduct1['product_id'];?>" class="wishlist addwishlist" 
																	href="javascript:void(0)"></a>
																	
                                                                
																<a data-toggle="tooltip" title="compare" class="compare" href="#"></a>
                                                                <a title="quick-view" product-id="<?php echo $bProduct1['product_id'];?>" data-toggle="modal" data-target="#productModal" class="q_view quick-view modal-view detail-link" href="#"></a>
                                                            </div>
                                                        </div>
                                                        <div class="des-container">
                                                            <h2 class="product-name">
                                                            <a title="Product details" href="product-details.php?product_id=<?php echo $bProduct1['product_id']; ?>"> <?php echo $bProduct1['name']; ?> </a>
                                                            </h2>
                                                            <div class="price-box">
                                                                <?php
                                                                if(isset($bProduct1['dis_price']) && $bProduct1['dis_price']>0){ ?> 
                                                                <span class="price">BDT <?php echo $bProduct1['dis_price'];?> </span>
                                                                <?php } ?>
                                                                        
                                                                <span class="price" <?php if(isset($bProduct1['dis_price']) && $bProduct1['dis_price']>0){
                                                                   ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $bProduct1['price'];?>
                                                                </span>
                                                              
                                                            </div>
                                                            <div class="ratings">
                                                                <div class="rating-box">
                                                                    <ul>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                        <li><i class="fa fa-star-half-o"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end single product -->
                                               <?php if(($j=='0' && $key > 0) || $key+1==$total_bproduct ){ ?> 
												
                                            </div>
                                            <!-- end product group -->
                                            <?php 
													} 
												}
											?> 
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end bestsellerproducts-area -->
                            <!-- start banner-area-2 -->
                            <div class="banner-area-2 mb-0">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="banner-box res">
                                            <a href="#"><img src="secure/<?php echo $banner1; ?>" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="banner-box mb-30">
                                            <a href="#"><img src="secure/<?php echo $banner2; ?>" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end banner-area-2 -->
                            
                        </div>
                    </div>
                </div>
                
                <?php $nAproducts = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product as p
                left join product_description as pd ON p.product_id = pd.product_id
                left join product_discount as prd ON  p.product_id = prd.product_id WHERE p.status='Active' ORDER BY p.product_id DESC limit 4, 25");
                ?>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Sale products area -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="productslider-area">
                                        <div class="Sale-products modul-title modul-title-style-1">
                                            <h2>New Arrivals</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- single Sale products owl -->
                                <div class="single-Sale-products indicator-style-1">
                                    <!-- single Sale products  -->
                                    <?php foreach($nAproducts as $nAproduct) {?>
                                    <div class="col-md-3">
                                        <div class="single-product">
                                            <div class="item-inner">
                                                <div class="img-container">
                                                    <a class="product-image" href="product-details.php?product_id=<?php echo $nAproduct['product_id']; ?>"><img src="secure/<?php echo $nAproduct['main_image']; ?>" alt="<?php echo $nAproduct['name']; ?>"></a>
                                                    <div class="actions">
                                                        
														<?php
														$id = $nAproduct['product_id'];
																	
														$stmtC = $myModel->customQuery("SELECT * FROM product_color
																			WHERE product_id = $id");
																	
														$stmtS = $myModel->customQuery("SELECT * FROM product_size
																			WHERE product_id = $id");
														if(isset($nAproduct['dis_price']) && $nAproduct['dis_price']>0){ 
															$nprice = $nAproduct['dis_price'];
														}else{
															$nprice = $nAproduct['price']; 
														}
																	
														if(count($stmtC) > 0 || count($stmtS) > 0 ){ ?>
																	
														<a product-id="<?php echo $nAproduct['product_id'];?>" data-toggle="modal" data-target="#cartpopup"  title="add-to-cart" class="add-to-cart cartpopup modal-view detail-link" href="#"></a>
																		
														<?php } else { ?>
																	
														<a data-toggle="tooltip" title="add-to-cart" class="add-to-cart" href="javascript:void(0)" onclick="addToCart(<?php echo $nAproduct['product_id'];?>, 1, <?php echo $nprice; ?>)"></a>
																	
														<?php } ?>
                                                        
													
														<a data-toggle="tooltip" title="wishlist" pro="<?php echo $nAproduct['product_id'];?>" class="wishlist addwishlist" 
														href="javascript:void(0)"></a>
														
                                                        
														<a data-toggle="tooltip" title="compare" class="compare" href="#"></a>
                                                        <a product-id="<?php echo $nAproduct['product_id'];?>" data-toggle="modal" data-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"></a>
                                                    </div>
                                                </div>
                                                <div class="des-container">
                                                    <h2 class="product-name">
                                                        <a title="Product details" href="product-details.php?product_id=<?php echo $nAproduct['product_id']; ?>"> <?php echo $nAproduct['name']; ?> </a>
                                                    </h2>
                                                    <div class="price-box">
                                                        <?php
                                                        if(isset($nAproduct['dis_price']) && $nAproduct['dis_price']>0){ ?> 
                                                        <span class="price">BDT <?php echo $nAproduct['dis_price'];?> </span>
                                                        <?php } ?>
                                                                        
                                                        <span class="price" <?php if(isset($nAproduct['dis_price']) && $nAproduct['dis_price']>0){
                                                            ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $nAproduct['price'];?>
                                                        </span>
                                                              
                                                    </div>
                                                    <div class="ratings">
                                                        <div class="rating-box">
                                                            <ul>
                                                                <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                                <li><i class="fa fa-star-half-o"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    
                                </div>
                                <!--end single Sale products  -->
                            </div>
                            <!-- end Sale products area  -->
                            <!-- end col md 12-->
                        </div>
                    </div>
                </div><br>
            </div>
        </section>
        <!-- End page content -->
        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>
    <!-- QUICKVIEW PRODUCT -->
    <?php include('views/quick-view.php') ?>
    <!-- END QUICKVIEW PRODUCT -->

    <?php include('views/footer-script.php'); ?>   


</body>
</html>