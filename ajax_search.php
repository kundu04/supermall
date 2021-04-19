<?php include("config.php") ?>


<?php  

	//---- ajax request    -------//

if(isset($_POST['keyword']))
{
		
	$search_word = mysql_escape_string($_POST['keyword']);
	
	
	if(isset($_POST['sort'])){
		$page_limit = $_POST['sort'];
	} else {
		$page_limit = 9;
	}
	
	if(isset($_GET['amount1']) && $_GET['amount1'] > 0){
		$lowest_price = $_GET['amount1'] ;
		$higest_price = $_GET['amount2'];

		$price_sql = " AND p.price > '$lowest_price' AND p.price < '$higest_price' ";
	} else {
		$price_sql = "";
	}
	
	$posValue = ''; $posKey = '';
	if(isset($_POST['position']) && $_POST['position']!=''){
		$position = $_POST['position'];
		$posArray = explode('-',$position);
		$posValue = $posArray[0];
		$posKey = $posArray[1];
		
		if($posKey=='name'){
			$position_order_sql = " ORDER BY pd.name $posValue";
		} else {
			$position_order_sql = " ORDER BY p.price $posValue";
		}
		
	} else {
		
		$position_order_sql = '';
	}
	
	if(isset($_POST['brandId']) && $_POST['brandId']!==''){
		$brand_id = $_POST['brandId'];
		$brand_sql = " AND p.manufacturer_id = $brand_id";
	} else {
		$brand_sql = '';
	}
	
	if(isset($_POST['color_id']) && $_POST['color_id']!==''){
		$color_id = $_POST['color_id'];
		$color_sql_join = " left join product_color ON p.product_id = product_color.product_id ";
		$color_sql = " AND product_color.color_id = $color_id";
	} else {
		$color_sql_join = '';
		$color_sql = '';
	}
	
	if(isset($_POST['size_id']) && $_POST['size_id']!==''){
		$size_id = $_POST['size_id'];
		$size_sql_join = " left join product_size ON p.product_id = product_size.product_id ";
		$size_sql = " AND product_size.size_id = $size_id";
	} else {
		$size_sql_join = '';
		$size_sql = '';
	}
	
	if(isset($_POST['p']) && $_POST['p'] > 1) { 
		$p = ceil($_POST['p'])-1;
	} else{
		$p = 0;
	}
	
	if(isset($_POST['cat_id']) && $_POST['cat_id']!==''){
		$cat_id = $_POST['cat_id'];
		$cat_sql = " AND pc.category_id = $cat_id";
	} else {
		$cat_sql = '';
	}

	
	$page_step = $p * $page_limit;
	
	$query = "SELECT p.*,pd.*,pc.*, prd.price as dis_price 
			FROM product as p
			left join product_to_category as pc 
				ON p.product_id = pc.product_id
			left join product_description as pd 
				ON p.product_id = pd.product_id
			left join product_discount as prd 
				ON  p.product_id = prd.product_id 
			".$color_sql_join.$size_sql_join."
			WHERE  p.status='Active' AND pd.name LIKE '%$search_word%' ".$brand_sql.$color_sql.$size_sql.$cat_sql.$price_sql.$position_order_sql;
	
	$total_items = count($myModel->customQuery($query));
	$products = $myModel->customQuery($query." LIMIT $page_step, $page_limit");

	$total_number_of_page = ceil($total_items / $page_limit);
	
	//  customize Product Price  //
	
	function rearrangePro_orderby(){
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	
	$rearrangePro = array();
	foreach($products as $product){
		
		if($product['price'] > $product['dis_price'] && $product['dis_price'] > 0){
			$sort_price = $product['dis_price'];
		} else {
			$sort_price = $product['price'];
		}
		$rearrangePro[] = array('product_id'=>$product['product_id'], 'category_id'=>$product['category_id'], 'main_image'=>$product['main_image'], 'price'=>$product['price'], 'dis_price'=>$product['dis_price'], 'name'=>$product['name'], 'description'=>$product['description'], 'sort_price'=>$sort_price);
	 
	}

	if($posKey!='name'){
		if($posValue=='desc')
			$products = rearrangePro_orderby($rearrangePro, 'sort_price', SORT_DESC);
		elseif($posValue=='asc')
			$products = rearrangePro_orderby($rearrangePro, 'sort_price', SORT_ASC);
	}
	
	
	//-  customize Product Price  -//
	
	
	
}



if(!$products ){
	echo '<br/><br/><h4><center>NO Products in this Keyword</center></h4><br/>';
} 
	

?>


<!------ ajax response with pagination  ---- -->

				
	


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
									<?php } ?>`
									
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
	</div>
	
	<div class="toolbar-bottom">
	
		<!-- Showing Products Status  -->
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			<div class="sort-by floatleft">
			<p>
			<?php 
			if($total_number_of_page == $p+1){
				$endValue = $total_items;
			}else {  
				$endValue = ($page_step+$page_limit); 
			}									
			echo 'Showing Products '.($page_step+1).' to '.$endValue.' of total '.$total_items.' items ( '.($p+1).'/'.$total_number_of_page.' Pages )';
			
			?> 
			</p>
			</div>
		</div>  
		<!-- Showing Products Status  -->
		
		<!-- Showing Products Pagination  -->
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
		
			<?php if($total_number_of_page > 1){ ?>
		
			<div class="pages text-right">
				<ul class="pagination">
					
					<?php
					// previous button
					if(!isset($_POST['p']) ){
						$prev = '#'; 
					} elseif($_POST['p']==1) {
						$prev = '1';
					} else { 
						$prev = ($_POST['p']-1); 
					}
					// next button
					if(!isset($_POST['p']) ){
						$next = '2'; 
					} elseif($total_number_of_page == $_POST['p']) {
						$next = $total_number_of_page;
					} else { 
						$next = ($_POST['p']+1); 
					}
					
					?>
					
					<li><a class="paginate_page" page="<?php echo $prev;  ?>" href="javascript:void(0)">Prev</a></li>
					
					<?php  
						for($i = 1; $i<=$total_number_of_page; $i++ ){ 

						if(!isset($_POST['p']) && $i==1 ) { 
							$active = 'style="background:#f45c5d; color:white;"';
						} elseif (isset($_POST['p']) && $_POST['p']==$i ){
							$active = 'style="background:#f45c5d; color:white;"';
						} else {
							$active = '';
						}
					?>
					<li><a <?php echo $active;?> class="paginate_page" page="<?php if($i>1){ echo $i; } else{ echo '#'; } ?>" href="javascript:void(0)"><?php echo $i; ?></a></li>
					<?php } ?>
					
					<li><a class="paginate_page " page="<?php echo $next;  ?>" href="javascript:void(0)">Next</a></li>

					
				</ul>
			</div>
			
			<?php	}	 ?>
			
		</div>
		<!-- Showing Products Pagination  -->
		
	</div>
	<script>
$(document).ready(function(){
	var search_word = '<?php echo $search_word;?>';
	$(".paginate_page").click(function(){
		var page = $(this).attr('page');
        filterData('0', '0', page, '0', '0', '0', '0');
    });
	
	function filterData(position, show, page, brandId, colorId, sizeId, catId){
		
		//$("#loading").show();
		
		if(position=='0'){
			var position = $('.changessort').val();
		} 
        if(show=='0'){
			var show = $('.changeshow').val();
		}
		if(brandId=='0'){
			var brandId = $('#setbrandId').val();
		}
		if(colorId=='0'){
			var colorId = $('#setcolorId').val();
		}
		if(sizeId=='0'){
			var sizeId = $('#setsizeId').val();
		}
		if(catId=='0'){
			var catId = $('#setcatId').val();
		}
	
		$.ajax({  
			 url:"ajax_search.php",  
			 method:"POST",  
			 data:{"keyword":search_word, "position":position, "sort":show, "p":page, "brandId":brandId, "color_id":colorId, "size_id":sizeId, "cat_id":catId},  
			 success:function(data){  
				  $("#product_view").html(data);  
				  $("#loading").hide(); 
			 }  
		});
		
		
	}
	
});
	</script>
