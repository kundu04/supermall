<?php include 'views/header-script.php'; ?>
<?php include ('includeConfig/urlsession.php'); ?>
<?php
function splitWord($text, $limit=450)
	{
		$length = strlen($text);
		if($length < $limit){
			return $text;
		}
		$split = substr($text, 0, $limit);
		$texts = substr($split, 0, strrpos($split, ' '));
		$texts .= ' ...';
		return $texts;	
	}		
?>

<?php
if(isset($_GET['product_id'])){

$product_id = ceil($_GET['product_id']);

if(isset($_SESSION['product_id']) && $_SESSION['product_id']!=''){
	
	  if($_SESSION['product_id']==$product_id){
		  
	  }
	  else{
		 $update = $myModel->customQuery("UPDATE product SET viewed=viewed + 1 WHERE product_id='$product_id'"); 
	  }
}
else{
	
	$_SESSION['product_id']=$product_id;
	
	$update = $myModel->customQuery("UPDATE product SET viewed=viewed + 1 WHERE product_id='$product_id'"); 
	
}
?>
<?php
//$category_id = ceil($_GET['category_id']);
$products = $myModel->customQuery("SELECT p.*,pd.*, pc.*, prd.price as dis_price, m.brand_name as brand FROM product as p
left join product_to_category as pc ON p.product_id = pc.product_id
left join product_description as pd ON p.product_id = pd.product_id
left join product_discount as prd ON  p.product_id = prd.product_id
left join manufacturer as m ON p.manufacturer_id = m.manufacturer_id
WHERE  p.product_id = '$product_id' AND  p.status='Active'");
 //AND pc.category_id='$category_id'
 $product_image = $myModel->customQuery("SELECT * FROM product_image WHERE product_id='$product_id'");
 $product_color = $myModel->customQuery("SELECT * FROM product_color, color WHERE product_color.color_id = color.color_id AND  product_id='$product_id'");
 $product_size = $myModel->customQuery("SELECT * FROM product_size, size WHERE product_size.size_id = size.size_id AND  product_id='$product_id'");
 
$stock_status_id = $products[0]['stock_status_id'];
$stock_name = $myModel->customQuery("SELECT st.stock_name FROM stock_status as st WHERE st.stock_status_id = '$stock_status_id'");

} else{
		header("Location:index.php");
	}

 ?>


</head>

<body>
        <!-- Start header area -->
        <header id="header" class="header-area">
            <?php include('views/header-top.php') ?>

            <!-- start main-menu area -->
            <?php include 'views/main-menu.php'; ?>

            <!-- Start mobile menu -->
            <?php include('views/mobile-menu.php'); ?>
        </header>
        <!-- End header area -->
        
    <!-- start page area -->
    <section class="page-content">
        <div class="main-content main-content-style-2">
            <!-- breadcrumbs area -->
            <div class="breadcrumbs">
                <div class="container">
                    <ul>
                        <li class="home"><a title="Go to Home Page" href="#">home</a><span></span></li>
                        <li class="category3"><strong>Quisque in arcu</strong></li>
                    </ul>
                </div>
            </div>
            <!--end breadcrumbs area -->
            <div class="single-product-view">
                <div class="container">
                    <div class="main-single-product-content margin-top">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
                                <!-- product-details-start-->
                                <div class="product-single-details">
                                    <div class="imgs-area">
                                        <img id="zoom_03" src="secure/<?php echo $products[0]['main_image']; ?>" data-zoom-image="secure/<?php echo $products[0]['main_image']; ?>" alt="<?php echo $products[0]['name']; ?>">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="gallery_01" class="indicator-style-5">
                                                    <div class="p-c"> 
                                                        <a href="#" data-image="secure/<?php echo $products[0]['main_image']; ?>" data-zoom-image="secure/<?php echo $products[0]['main_image']; ?>">
                                                            <img id="zoom_03" src="secure/<?php echo $products[0]['main_image']; ?>" data-zoom-image="secure/<?php echo $products[0]['main_image']; ?>" alt="<?php echo $products[0]['name']; ?>">
                                                        </a>
                                                    </div>
                                                    
                                                    <?php foreach($product_image as $image){ ?>
                                                    <div class="p-c">
                                                        <a href="#" data-image="secure/<?php echo $image['image']; ?>" data-zoom-image="secure/<?php echo $image['image']; ?>">
                                                            <img class="zoom_03" src="secure/<?php echo $image['image']; ?>" alt="">
                                                        </a>
                                                    </div>
                                                   <?php } ?>                                                   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5  col-sm-6 col-xs-12 col-lg-5">
                                <div class="product-shop">
                                    <div class="des-container des-container-2">
                                        <h2 class="product-name">
                                        <a href="#"> <?php echo $products[0]['name']; ?> </a>
                                        </h2>
                                        <div class="price-rt">
                                            <div class="price-box floatleft">
                                                <span class="price">
												<?php
												if(isset($products[0]['dis_price']) && $products[0]['dis_price']>0) { ?> 
													<span class="price">BDT <?php echo $products[0]['dis_price']; ?></span>
												<?php } ?>

													<span class="price" <?php if(isset($products[0]['dis_price']) && $products[0]['dis_price']>0){ ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?>>BDT <?php echo $products[0]['price']; ?>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="ratings floatright">
                                                <div class="rating-box">
                                                    <ul>
                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                        <li class="yes"><i class="fa fa-star-half-o"></i></li>
                                                        <li><i class="fa fa-star-half-o"></i></li>
                                                    </ul>
                                                </div>
                                                <span class="amount">
                                                    <a href="#">1 Review(s)</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="short-description">
                                        <div class="std">
                                            <?php echo splitWord( $products[0]['description'], 445);?>
                                        </div>
                                    </div>
                            <form action="" method="">
									<?php if($products[0]['quantity'] > 0 ){ ?>
									
									<div class="row">
                                    <?php if(count($product_color) > 0){ ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                                            <label>Color</label>
											<select id="color" class="form-control">
                                                <option value="">Choose Color</option>
                                                <?php foreach($product_color as $color){ ?>
                                                <option value="<?php echo $color['color_id']; ?>"><?php echo $color['color_name']; ?></option>
                                                <?php } ?>
                                            </select>
											<div style="color:#F45C5D" id="showmsgC"></div>
                                        </div>
                                        <?php } ?>
                                        <?php if(count($product_size) > 0){ ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                                            <label>Size</label>
											<select id="size" class="form-control">
                                                <option value="">Choose Size</option>
                                                <?php foreach($product_size as $size){ ?>
                                                <option value="<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></option>
                                                <?php } ?>
                                            </select>
											<div style="color:#F45C5D" id="showmsgS"></div>
                                        </div>
                                      <?php } ?>
                                    </div>
									
									<?php 
									if(isset($products[0]['dis_price']) && $products[0]['dis_price']>0){ 
											$price = $products[0]['dis_price'];
									}else{
											$price = $products[0]['price']; 
									}?>
									
                                    
                                    <div class="add-to-box-cart">
                                        <div class="add-to-cart">
                                            <div class="cart-quantity">
                                                <label for="qty">Qty:</label>
                                                <div class="cart-plus-minus">
                                                    <input id="proQnt" class="cart-plus-minus-box" type="text" value="1" min=1 />
                                                </div>
                                            </div>

                                            <button class="button btn-cart" type="button" title="Add to Cart" onclick="addToCart(<?php echo $products[0]['product_id']; ?>, 0, <?php echo $price; ?>,'color', 'size')">
                                                <span>
                                                    <span>Add to Cart</span>
                                                </span>
                                            </button>
                                           
											<div class="single-product-action">
																	
												<a href="javascript:void(0)" pro="<?php echo $products[0]['product_id'];?>" class="s-wishlist addwishlist" data-toggle="tooltip" data-original-title="wishlist"><i class="fa fa-heart-o"></i></a>
												
												<a href="#" class="s-email" data-toggle="tooltip" data-original-title="Mail to a friend"><i class="fa fa-envelope"></i></a>
											
											</div>
                                  
                                        </div>
                                    </div>
                                  <?php } ?>
							</form>
                                  
                                    <div class="product-social">
                                        <div id="share"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3  col-sm-12 col-xs-12 col-lg-3">
                                <table class="table">
                                    <tr>
                                        <td><b>Availability :</b></td>
                                        <td <?php if($stock_name[0]['stock_name'] == "Out Of Stock"){?> style="color:red; font-weight:bold;"<?php } ?>><?php echo $stock_name[0]['stock_name']; ?></td>
                                    </tr>
                                    <?php if($products[0]['manufacturer_id'] > 0 && $products[0]['brand'] != "No-Brand" ){ ?>
                                    
									<tr>
                                        <td><b>Brand :</b></td>
                                        <td><?php echo $products[0]['brand']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($products[0]['model'] != "" ){ ?>
                                    <tr>
                                        <td><b>Model :</b></td>
                                        <td><?php echo $products[0]['model']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="product-menu">
                                    <ul class="single-product-tablist">
                                        <li class="active first"><a href="#description" data-toggle="tab" aria-expanded="false">DESCRIPTION</a></li>
                                        <li class=""><a href="#review" data-toggle="tab" aria-expanded="false">REVIEW</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="product-list tab-content">
                                    <div class="tab-pane fade active in" id="description">
                                        <p><?php echo $products[0]['description']; ?></p>
                                    </div>
                                    <div class="tab-pane fade" id="review">
                                        <div class="custom-container">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div id="reviews">
                                                        <div id="comments">
                                                            <h2 class="review-title">2 reviews for ArchitectMade Oscar Figure</h2>
                                                            <ol class="commentlist">
                                                                <li class="comment">
                                                                    <div class="comment_container">
                                                                        <img class="avatar" src="img/avatars/1.png" alt="">
                                                                        <div class="comment-text">
                                                                            <div class="meta">
                                                                                <strong>Stuart</strong>-
                                                                                <time datetime="2013-06-07T13:01:25+00:00">June 7, 2013</time>
                                                                                <div title="Rated 5 out of 5" class="rating">
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="description">
                                                                                <p>This will go great with my Hoodie that I ordered a few weeks ago.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="comment">
                                                                    <div class="comment_container">
                                                                        <img class="avatar" src="img/avatars/2.png" alt="">
                                                                        <div class="comment-text">
                                                                            <div class="meta">
                                                                                <strong>Stuart</strong>-
                                                                                <time datetime="2013-06-07T13:01:25+00:00">June 7, 2013</time>
                                                                                <div title="Rated 5 out of 5" class="rating">
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="description">
                                                                                <p>This will go great with my Hoodie that I ordered a few weeks ago.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="comment">
                                                                    <div class="comment_container">
                                                                        <img class="avatar" src="img/avatars/3.png" alt="">
                                                                        <div class="comment-text">
                                                                            <div class="meta">
                                                                                <strong>Stuart</strong>-
                                                                                <time datetime="2013-06-07T13:01:25+00:00">June 7, 2013</time>
                                                                                <div title="Rated 5 out of 5" class="rating">
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="description">
                                                                                <p>This will go great with my Hoodie that I ordered a few weeks ago.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div id="review_form">
                                                        <div class="comment-respond">
                                                            <h3 class="comment-reply-title">Add a review</h3>
                                                            <form class="comment-form">
                                                                <p>
                                                                    <label>Your Rating</label>
                                                                    <span class="stars">
                                                                        <span>
                                                                            <a href="javascript:void(0)" class="star-1" data-rating="1">1</a>
                                                                            <a href="javascript:void(0)" class="star-1" data-rating="2">2</a>
                                                                            <a href="javascript:void(0)" class="star-1" data-rating="3">3</a>
                                                                            <a href="javascript:void(0)" class="star-1" data-rating="4">4</a>
                                                                            <a href="javascript:void(0)" class="star-1" data-rating="5">5</a>
                                                                        </span>
                                                                    </span>
                                                                </p>
                                                              
                                                                
                                                                <p>
                                                                    <label>Comment</label>
                                                                    <textarea rows="8" name="comment" id="comment"></textarea>
                                                                </p>
                                                                <p>
																    <input type="hidden" id="rating_value" name="rating_value" value="" />
                                                                    <input type="submit" value="Submit" class="submit" id="submit" name="submit">
                                                                </p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Start page content -->
	<?php
	//Start related products
	
	$rProducts = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product_related as pr 
	left join product_description as pd ON pr.related_id = pd.product_id
	left join product_discount as prd ON pr.related_id = prd.product_id 
	left join product as p ON pr.related_id = p.product_id 
	WHERE pr.product_id = '$product_id'");
	?>
	
	<?php if(count($rProducts) > 0){ ?>
    <div class="single-relatedproduct-area">
        <div class="container">
            <!-- Sale products area -->
            <div class="row">
                <div class="col-md-12">
                    <div class="productslider-area">
                        <div class="Sale-products modul-title modul-title-style-1">
                            <h2>Related Products</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single Sale products owl -->
                <div class="single-Sale-products indicator-style-1">
                    <!-- single Sale products  -->
                    <?php foreach($rProducts as $rProduct) {?>
					<div class="col-md-3">
						<div class="single-product">
							<div class="item-inner">
								<div class="img-container">
									<a class="product-image" href="product-details.php?product_id=<?php echo $rProduct['product_id']; ?>"><img src="secure/<?php echo $rProduct['main_image']; ?>" alt="<?php echo $rProduct['name']; ?>">
									</a>
                                    
									<div class="actions">
									
									<a data-toggle="tooltip" title="wishlist" pro="<?php echo $rProduct['product_id'];?>" class="wishlist addwishlist" href="javascript:void(0)"></a>
									                    
									<a data-toggle="tooltip" title="compare" class="compare" href="#"></a>
									
									</div>
								</div>
                                <div class="des-container">
									<h2 class="product-name">
										<a title="Product details" href="product-details.php?product_id=<?php echo $rProduct['product_id']; ?>"> <?php echo $rProduct['name']; ?> </a>
                                    </h2>
                                    <div class="price-box">
										<?php
										if(isset($rProduct['dis_price']) && $rProduct['dis_price']>0){ ?> 
                                           <span class="price">BDT <?php echo $rProduct['dis_price'];?> </span>
                                        <?php } ?>
                                                                        
                                           <span class="price" <?php if(isset($rProduct['dis_price']) && $rProduct['dis_price']>0){ ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $rProduct['price'];?>
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
        </div>
    </div>
	<?php }?>
	<br>
    <!--End our-brand-section  -->
    <!-- Start footer content -->
    <?php include('views/footer.php'); ?>
    <!-- End footer content area -->
    <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    <!-- QUICKVIEW PRODUCT -->
    <?php include('views/quick-view.php') ?>
    <!-- END QUICKVIEW PRODUCT -->

    <?php include('views/footer-script.php'); ?>
</body>
</html>