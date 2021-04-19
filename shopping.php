<?php include ('views/header-script.php'); ?>
<?php include ('includeConfig/urlsession.php'); ?>
<!--Start Code for category option with pagination-->
<?php 
if(isset($_GET['cat_id'])){
$category_id = ceil($_GET['cat_id']);
$page_limit = 9;

if(isset($_GET['brand_id']) && $_GET['brand_id']!='0'){
	$brand_id = $_GET['brand_id'];
	$brand_sql = " AND p.manufacturer_id = $brand_id";
} else {
	$brand_sql = '';
}

if(isset($_GET['color_id']) && $_GET['color_id']!='0'){
	$color_id = $_GET['color_id'];
	$color_sql_join = " left join product_color ON p.product_id = product_color.product_id ";
	$color_sql = " AND product_color.color_id = $color_id";
} else {
	$color_sql_join = '';
	$color_sql = '';
}

if(isset($_GET['size_id']) && $_GET['size_id']!='0'){
	$size_id = $_GET['size_id'];
	$size_sql_join = " left join product_size ON p.product_id = product_size.product_id ";
	$size_sql = " AND product_size.size_id = $size_id";
} else {
	$size_sql_join = '';
	$size_sql = '';
}

if(isset($_GET['p']) && $_GET['p'] > 1)
   { $p = ceil($_GET['p'])-1;}
else{
    $p = 0;
}

$page_step = $p * $page_limit;

$total_items = $myModel->customQuery("SELECT count(*) as total FROM product as p
left join product_to_category as pc ON p.product_id = pc.product_id
left join product_description as pd ON p.product_id = pd.product_id
left join product_discount as prd ON  p.product_id = prd.product_id 
".$color_sql_join.$size_sql_join."
WHERE  p.status='Active' AND pc.category_id = '$category_id' ".$brand_sql.$color_sql.$size_sql);

$total_number_of_page = ceil($total_items[0]['total'] / $page_limit);

$products = $myModel->customQuery("SELECT p.*,pd.*,pc.*, prd.price as dis_price FROM product as p
left join product_to_category as pc ON p.product_id = pc.product_id
left join product_description as pd ON p.product_id = pd.product_id
left join product_discount as prd ON  p.product_id = prd.product_id 
".$color_sql_join.$size_sql_join."
WHERE  p.status='Active' AND pc.category_id = '$category_id'".$brand_sql.$color_sql.$size_sql." LIMIT $page_step, $page_limit");


} else {
	header("Location:index.php");
}

?>
<!--End Code for category option with pagination-->


<style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
</style>
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
        
        <!-- start page area -->
        <section class="page-content">
            <div class="main-content mb-30 main-content-2">
                <!-- breadcrumbs area -->
                <div class="breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="breadcrumb-inner">
                                    <ul>
                                        <li class="home"><a title="Go to Home Page" href="#">home</a><span></span></li>
                                        
                                        <li class="last"><strong>headphone</strong></li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end breadcrumbs area -->
                <div class="container">
                    <div class="main">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <!--start breadcrumbs area -->
                                <div class="block block-layered-nav">
                                    <div class="block-title">
                                        <strong><span>Shop By</span></strong>
                                    </div>
                                    <div class="block-content">
                                        <div class="narrow-by-list">
                                            <div class="layered layered-Category">
                                                <h2>Category</h2>
                                                <div class="content-shopby">
                                                    <ul>
                                                        <?php foreach($queryResult as $catListSidebar) { ?> 
                                                        
                                                        <?php
                                                            $catId = $catListSidebar["category_id"];
                                                            $pQ = $myModel->customQuery("SELECT count(*) as total FROM product as p
                                                            left join product_to_category as pc ON p.product_id = pc.product_id
                                                            WHERE  pc.category_id = '$catId' AND p.status='Active'"); 
                                                            $tpQ = $pQ[0]['total'];
                                                        ?>
                                                                                                                
                                                        <li><a href="shopping.php?cat_id=<?php echo $catListSidebar["category_id"];?>"><?php echo $catListSidebar['cat_name']; ?></a>(<?php echo $tpQ; ?>)</li>

                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            
											<!--Start Brand Sidebar -->
											<?php 
                                            $brands = $myModel->customQuery("SELECT p.manufacturer_id, pc.category_id as cat_id, count(p.product_id) as total, m.brand_name as brand FROM product as p 
                                            left join product_to_category as pc ON p.product_id = pc.product_id 
                                            left join manufacturer as m ON p.manufacturer_id = m.manufacturer_id 
                                            WHERE pc.category_id = '$category_id' AND p.status='Active' GROUP BY manufacturer_id ORDER BY brand");  
                                            ?>
											
											<?php if(count($brands) > 0){ ?>
                                            
											<div class="layered layered-Category">
                                                <h2>Brand</h2>
                                                <div class="content-shopby">
                                                    <ul>                                                        
                                                        <?php foreach($brands as $brand){ ?>    
                                                           <li>
																<a href="shopping.php?cat_id=<?php echo $brand['cat_id'];?>&brand_id=<?php echo $brand['manufacturer_id']; ?>">
																
																<?php if($brand['manufacturer_id'] == 0 ) { echo 'No-Brand';}else{ echo $brand['brand'];} ?>
																
																</a>
																(<?php echo $brand['total']; ?>)
															</li>															
                                                        <?php } ?>
                                                    </ul>                                                  
                                                </div>
                                            </div>
                                            <?php } ?>                                            
                                            
											<!--End Brand Sidebar -->
                                            
											<!--Start Color Sidebar -->
                                            <?php 
											$productsId = $myModel->customQuery("SELECT p.product_id FROM product as p left join product_to_category as pc ON p.product_id = pc.product_id WHERE  pc.category_id = '$category_id' AND p.status='Active'");
													
											$col = array();													
											foreach($productsId as $value){
												$proId = $value['product_id'];
												$proColor = $myModel->customQuery("SELECT color.* FROM color
												LEFT JOIN product_color ON color.color_id = product_color.color_id 
												WHERE product_id = $proId");	
												foreach($proColor as $value){
												$col[] = array('color_name'=>$value['color_name'], 'color_id'=>$value['color_id']);
												}
											}													
											$serialize = array_map("serialize", $col);
													
											$count = array_count_values ($serialize);
											$colorArray = array_unique($serialize);

											foreach($colorArray as &$u){
												$u_count = $count[$u];
												$u = unserialize($u);
												$u['count'] = $u_count;
											}
											asort($colorArray);?>
											
											<?php if(count($colorArray) > 0){ ?>
                                            
											<div class="layered layered-brand">
                                                <h2>Color</h2>
                                                <div class="content-shopby">												
													<ul>                                                       
                                                    
													<?php foreach($colorArray as $color){ ?>    
														<li>
															<a href="shopping.php?cat_id=<?php echo $category_id;?>&color_id=<?php echo $color['color_id']; ?>">
																												
															<?php echo $color['color_name']; ?>
															</a>
															(<?php echo $color['count']; ?>)
														</li>
                                                    <?php } ?>
                                                    
													</ul>                                                  
                                                </div>
                                            </div>
											
											<?php } ?>
											
                                            <!--End Color Sidebar -->
                                            
											<!--Start Size Sidebar -->
                                            <?php
											$siz = array();													
											foreach($productsId as $value){
											$proId = $value['product_id'];
											$proSize = $myModel->customQuery("SELECT size.* FROM size
											LEFT JOIN product_size ON size.size_id = product_size.size_id 
											WHERE product_id = $proId");	
												foreach($proSize as $value){
												$siz[] = array('size_name'=>$value['size_name'], 'size_id'=>$value['size_id']);
												}
											}													
											$serialize = array_map("serialize", $siz);
											$count     = array_count_values ($serialize);
											$sizeArray    = array_unique($serialize);

											foreach($sizeArray as &$u){
												$u_count = $count[$u];
												$u = unserialize($u);
												$u['count'] = $u_count;
											}
											asort($sizeArray);?>
											
											<?php if(count($sizeArray) > 0){ ?>
											
											<div class="layered layered-brand">
                                                <h2>Size</h2>
                                                <div class="content-shopby">                                                
													<ul>                                                       
                                                    
													<?php foreach($sizeArray as $size){ ?>    
														<li>
															<a href="shopping.php?cat_id=<?php echo $category_id;?>&size_id=<?php echo $size['size_id']; ?>">
															
															<?php echo $size['size_name']; ?>
															</a>
															(<?php echo $size['count']; ?>)
														</li>
                                                    <?php } ?>
                                                    
													</ul>                                                   
                                                </div>
                                            </div>
											
											<?php } ?>											
                                            <!--End Size Sidebar -->
											
											<!--Start Price range Sidebar -->
                                            <div class="layered layered-price" style="padding-top:15px">
                                                <h2>Price Range</h2>
                                                <div class="content-shopby">
                                                    <div class="amount">                                             
                                                        <input type="text" id="amount" name="amount" readonly style="border:0; font-weight:500;">
                                                    </div>
                                                    <div id="slider-range" style="margin-bottom: 10px"></div>
                                                </div>
                                            </div>											
											<!--End Price range Sidebar -->
											
                                        </div>
                                    </div>                                    
                                </div>
                                <!--end breadcrumbs area -->
                                
                                <!--start block list-->
                                <div class="block block-list block-compare">
                                    <div class="block-title">
                                        <strong>
                                            <span>Compare</span>
                                        </strong>
                                    </div>
                                    <div class="block-content">
                                        <p class="empty">You have no items to compare.</p>
                                    </div>
                                </div>
                                <!--end block list-->
                                
                            </div>
                            <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                                <!--product-view-mode -->
                                <div class="product-view-mode">
                                    <div class="product-option">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
                                                <!-- Nav tabs -->
                                                <div class="floatleft tabviewport">
                                                    <ul class="view-mode-menu clearfix">
                                                        <li class="active">
                                                            <a href="#grid" class="view" aria-controls="grid" data-toggle="tab">
                                                                <i title="grid"  class="fa fa-th-large "></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#list" class="view" aria-controls="list" data-toggle="tab">
                                                                <i title="list" class="fa fa-list"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4  col-sm-4 col-lg-4 col-xs-12">
                                                <div class="sort-by floatright">
                                                    <label>Sort By:</label>
                                                    <select  class="cust-select-1 changessort" data-ajax="cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>">
                                                       <option selected="selected" value="">Position</option>
                                                       <option value="asc-name">A-Z</option>
                                                       <option value="desc-name">Z-A</option>
                                                       <option value="desc-price">High - Low</option>
                                                       <option value="asc-price">Low - High</option>
                                                   </select>
                                                    <div class="custm-select-icon">
                                                        <a title="Set Descending Direction" href="#">
                                                            <img src="img/icon/gif-img/i_asc_arrow.gif" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
                                                <div class="sort-by floatright">
                                                    <label>Show:</label>
                                                    <select class="cust-select-1 changeshow" data-ajax="cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>">
                                                       <option selected="selected" value="9">9</option>
                                                       <option value="12">12</option>
                                                       <option value="24">24</option>
                                                       <option value="36">36</option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Tab panes -->
                                    <div class="loader" id="loader" style="display:none"></div>
                                    <div class="tab-content" id="ajaxContent">
                                        <div role="tabpanel" class="tab-pane active fade in" id="grid">
                                            
                                            <div class="row">
                                                <!--  single-product-->
                                                <?php foreach($products as $product){ ?>
                                                <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
                                                    <div class="single-product">
                                                        <div class="item-inner">
                                                            <div class="img-container">
                                                                <a class="product-image" href="product-details.php?product_id=<?php echo $product['product_id']; ?>"><img src="secure/<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>"></a>
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
																    
																	<?php if(isset($_SESSION['cust_id'])){	
																	?>
																	<a data-toggle="tooltip" title="wishlist" pro="<?php echo $product['product_id'];?>" class="wishlist addwishlist" 
																	href="javascript:void(0)"></a>
																	<?php } else { ?>
																		<a data-toggle="tooltip" title="wishlist"  class="wishlist" 
																	href="login.php"></a>
																	<?php } ?>
																	
                                                                    <a data-toggle="tooltip" title="compare" class="compare" href="#"></a>
                                                                    <a product-id="<?php echo $product['product_id'];?>" data-toggle="modal" data-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"></a>
                                                                </div>
                                                            </div>
                                                            <div class="des-container">
                                                                <h2 class="product-name">
                                                                <a title="Product details" href="product-details.php?product_id=<?php echo $product['product_id']; ?>&category_id=<?php echo $product['category_id']; ?>"> <?php echo $product['name']; ?> </a>
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
                                            </div>
                                            
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="list">
                                            <!--item-old  -->
                                            <div class="item-old">
                                                <?php foreach($products as $product){ ?>
                                                <div class="row">
                                                    <!--  single-product-->
                                                    <div class="col-md-4 col-lg-4 col-sm-5 col-xs-12 ">
                                                        <div class="single-product">
                                                            <div class="item-inner">
                                                                <div class="images-container">
                                                                    <a class="product-image" href="product-details.php?product_id=<?php echo $product['product_id']; ?>&category_id=<?php echo $product['category_id']; ?>"><img src="secure/<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Start des-container-->
                                                    <div class="col-md-8 col-lg-8 col-sm-7 col-xs-12 ">
                                                        <!--  des-container-->
                                                        <div class="des-container des-container-2">
                                                            <h2 class="product-name">
                                                            <a href="product-details.php?product_id=<?php echo $product['product_id']; ?>&category_id=<?php echo $product['category_id']; ?>"> <?php echo $product['name']; ?> </a>
                                                            </h2>
                                                            <div class="price-box floatleft">
                                                                <?php
                                                                if(isset($product['dis_price']) && $product['dis_price']>0){ ?> 
                                                                        <span class="price">BDT <?php echo $product['dis_price'];?> </span>
                                                                <?php } ?>
                                                                        
                                                                        <span class="price" <?php if(isset($product['dis_price']) && $product['dis_price']>0){
                                                                            ?> style="text-decoration: line-through; color: #838383; font-weight: normal;" <?php } ?> >BDT <?php echo $product['price'];?>
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
															
															
                                                            <p class="product-desc">
															
															<?php //echo $product['description']; ?>
                                                            
															</p>
                                                            
															
															<div class="add-to-box-cart">
                                                                <div class="add-to-cart">
                                                                    <div class="cart-quantity">
                                                                        <label for="proQnt">Qty:</label>
                                                                        <div class="cart-plus-minus">
                                                                            <input id="proQnt" class="cart-plus-minus-box" type="text" value="1" min="1" />
                                                                        </div>
                                                                    </div>
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
                                                                    
																	<button product-id="<?php echo $product['product_id'];?>" data-toggle="modal" data-target="#cartpopup" class="button btn-cart cartpopup modal-view detail-link">
																		<span>
                                                                            <span>Add to Cart</span>
                                                                        </span>
                                                                    </button>
																	
												<?php } else { ?>
																	
																	<button class="button btn-cart" type="button" title="Add to Cart" onclick="addToCart(<?php echo $product['product_id']; ?>, 1, <?php echo $price; ?>)">
																		<span>
																			<span>Add to Cart</span>
																		</span>
																	</button>
																
												<?php } ?>		
																
																</div>
                                                            </div>
                                                            <div class="add-to-box">
                                                                <div class="single-product-action">
                                                                    <a href="#" class="s-add-to-cart" data-toggle="tooltip" data-original-title="add-to-cart"><i class="fa fa-facebook"></i></a>
                                                                    
																	
																	<?php if(isset($_SESSION['cust_id'])){		
																	?>
																	
																	<a href="javascript:void(0)" pro="<?php echo $product['product_id'];?>" class="s-wishlist addwishlist" data-toggle="tooltip" data-original-title="wishlist"   
																	><i class="fa fa-heart-o"></i></a>
																	
																	<?php } else { ?>
																		<a href="login.php" 
																	class="s-wishlist" data-toggle="tooltip" data-original-title="wishlist"><i class="fa fa-heart-o"></i>
																	</a>
																	<?php } ?>
                                                                    
																	<a href="#" class="s-email" data-toggle="tooltip" data-original-title="Email"><i class="fa fa-envelope"></i></a>
                                                                    <a href="#" class="s-quick-view" data-toggle="tooltip" data-original-title="quick-view"><i class="fa fa-search"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End des-container-->
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <!--item-old  -->
                                            
                                        </div>
									<div class="toolbar-bottom">
										<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
											<div class="sort-by floatleft">
											<p>
											<?php 
											if($total_number_of_page == $p+1){
												$endValue = $total_items[0]['total'];
											}else {  
												$endValue = ($page_step+$page_limit); 
											}									
											echo 'Showing Products '.($page_step+1).' to '.$endValue.' of total '.$total_items[0]['total'].' items ( '.($p+1).'/'.$total_number_of_page.' Pages )';
											
											?> 
											</p>
											</div>
										</div>                                  
										
										<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
										
										<?php if($total_number_of_page > 1){ ?>
										
										<div class="pages text-right">
											<ul class="pagination">
											<li><a class="ajax" data-ajax="<?php if(ceil(@$_GET['p']) > 1){ ?>cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>&p=<?php echo ceil(@$_GET['p'])-1; ?><?php } else{ echo "#";} ?>" href="javascript:void(0)">Prev</a></li>
	
											<?php for($i = 1; $i<=$total_number_of_page; $i++ ){ ?>
												<li><a class="active ajax" data-ajax="<?php if($i>1){ ?>cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>&p=<?php echo $i; } else{ echo '#'; } ?>" href="javascript:void(0)"><?php echo $i; ?></a></li>
	
												<?php } ?>
	
											<li><a class = "ajax" data-ajax="<?php if(ceil(@$_GET['p']) < $total_number_of_page){ ?>cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>&p=<?php if(!isset($_GET['p']))  echo '2'; else{ ?><?php echo ceil(@$_GET['p'])+1; } ?> <?php } else{ echo "#";} ?>" href="javascript:void(0)">Next</a></li>
											</ul>
										</div>
										<?php } ?>
											
										</div>
									</div>
									
                                  </div>
                                </div>
                                <!--End product-view-mode -->
                               
                                <!--end buttom toolbar  -->

                                <!-- End page area -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
		
        <!-- end wrapper-->
    </div>
    <!-- QUICKVIEW PRODUCT -->
    <?php include('views/quick-view.php') ?>
    <!-- END QUICKVIEW PRODUCT -->
    <input type="hidden" id="view_value" value="grid" />
    <?php include('views/footer-script.php'); ?>
	<input type="hidden" id="amount1" value="0" />
	<input type="hidden" id="amount2" value="0" />
    <script type="text/javascript">
$(document).ready(function(){
    $(".ajax").click(function(){

        var data = $(this).attr('data-ajax');
        var value = $('.changessort').val();
		var amount1 = $('#amount1').val();
		var amount2 = $('#amount2').val();
			
       if(data!='#')
       {
         $("#loader").show();
        data = data+'&view=' + $('#view_value').val() + '&position=' + value+'&amount1='+amount1+"&amount2="+amount2;

        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data: data

        }).done(function(response){
					
           $("#ajaxContent").html(response);
            $("#loader").hide();
    
        });
	}
    });

    $(".view").click(function(){

    var data = $(this).attr('aria-controls');
    $('#view_value').val(data);

    });
});


$(document).ready(function(){
    $(".changeshow").change(function(){
        
        var cat_id = $(this).attr('data-ajax');
        var value = $(this).val();
		var pos = $('.changessort').val();
        var data = cat_id+'&sort=' + value + '&view=' + $('#view_value').val() +'&position=' + pos;

        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data: data

        }).done(function(response){
           $("#ajaxContent").html(response);
        });
      
    });
});


$(document).ready(function(){
    $(".changessort").change(function(){
        
        var cat_id = $(this).attr('data-ajax');
        var value = $(this).val();
        var page_limit = $('.changeshow').val();
        var data = cat_id+'&sort=' + page_limit+'&view=' + $('#view_value').val() + '&position=' + value;

        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data: data

        }).done(function(response){
           $("#ajaxContent").html(response);
        });
      
    });
});

</script>
  
</body>
</html>