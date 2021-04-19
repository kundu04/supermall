<?php include("config.php") ?>
<?php 

$posKey = "";
$posValue = "";

function array_orderby(){
    
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


if(isset($_GET['cat_id'])){
$category_id = ceil($_GET['cat_id']);

if(isset($_GET['sort'])){
    $page_limit = $_GET['sort'];
}
else{

    $page_limit = 9;
}

if(isset($_GET['amount1']) && $_GET['amount1'] > 0){
	$amount1 = $_GET['amount1'] ;
	$amount2 = $_GET['amount2'];

	$sql_1 = " AND p.price > '$amount1' AND p.price < '$amount2' ";
}
else{
	$sql_1 = "";
}

if(isset($_GET['position']) && $_GET['position']!=''){
    $position = $_GET['position'];

    $posArray = explode('-',$position);
    $posValue = $posArray[0];
    $posKey = $posArray[1];
     if($posKey=='name'){

    $sql = " ORDER BY pd.name $posValue";

      }
    else{

        $sql = " ORDER BY p.price $posValue";
    }
}
else{

    $position = '';
    $sql = '';
}

if(isset($_GET['brand_id']) && $_GET['brand_id']!='0'){
	$brand_id = $_GET['brand_id'];
	$brand_sql = " AND p.manufacturer_id = $brand_id ";
} else {
	$brand_sql = '';
}

if(isset($_GET['color_id']) && $_GET['color_id']!='0'){
	$color_id = $_GET['color_id'];
	$color_sql_join = " left join product_color ON p.product_id = product_color.product_id ";
	$color_sql = " AND product_color.color_id = $color_id ";
} else {
	$color_sql_join = '';
	$color_sql = '';
}

if(isset($_GET['size_id']) && $_GET['size_id']!='0'){
	$size_id = $_GET['size_id'];
	$size_sql_join = " left join product_size ON p.product_id = product_size.product_id ";
	$size_sql = " AND product_size.size_id = $size_id ";
} else {
	$size_sql_join = '';
	$size_sql = '';
}

if(isset($_GET['p']) && $_GET['p'] > 1){ 
	$p = ceil($_GET['p'])-1;
} else {
    $p = 0;
}

$view = $_GET['view'];
$page_step = $p * $page_limit;


$total_items = $myModel->customQuery("SELECT count(*) as total FROM product as p
left join product_to_category as pc ON p.product_id = pc.product_id
left join product_description as pd ON p.product_id = pd.product_id
left join product_discount as prd ON  p.product_id = prd.product_id 
".$color_sql_join.$size_sql_join."
WHERE  p.status='Active' AND pc.category_id = '$category_id' ".$brand_sql.$color_sql.$size_sql.$sql_1.$sql);

$total_number_of_page = ceil($total_items[0]['total'] / $page_limit);

$products = $myModel->customQuery("SELECT p.*,pd.*,pc.*, prd.price as dis_price FROM product as p
left join product_to_category as pc ON p.product_id = pc.product_id
left join product_description as pd ON p.product_id = pd.product_id
left join product_discount as prd ON  p.product_id = prd.product_id 
".$color_sql_join.$size_sql_join."
WHERE  p.status='Active' AND pc.category_id = '$category_id'".$brand_sql.$color_sql.$size_sql.$sql_1.$sql." LIMIT $page_step, $page_limit");

}


$newArray = array();
foreach($products as $newA){
  if($newA['price'] > $newA['dis_price'] && $newA['dis_price'] > 0){
    $sort_price = $newA['dis_price'];
  }
  else{

    $sort_price = $newA['price'];
  }
 $newArray[] = array('product_id'=>$newA['product_id'], 'category_id'=>$newA['category_id'], 'main_image'=>$newA['main_image'], 'price'=>$newA['price'], 'dis_price'=>$newA['dis_price'], 'name'=>$newA['name'], 'description'=>$newA['description'], 'sort_price'=>$sort_price);
}


if($posKey!='name'){
if($posValue=='desc')
$products = array_orderby($newArray, 'sort_price', SORT_DESC);
elseif($posValue=='asc')
$products = array_orderby($newArray, 'sort_price', SORT_ASC);

}
?>

<!--Start Code for view products by ajax with pagination-->

					<div role="tabpanel" class="tab-pane fade <?php if($view=='grid'){ echo 'active in'; } ?>" id="grid">
                                            
                                            <div class="row">
                                                <!--  single-product-->
                                                <?php foreach($products as $product){ ?>
                                                <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
                                                    <div class="single-product">
                                                        <div class="item-inner">
                                                            <div class="img-container">
                                                                <a class="product-image" href="product-details.php?product_id=<?php echo $product['product_id']; ?>&category_id=<?php echo $product['category_id']; ?>"><img src="secure/<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>"></a>
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
                  <div role="tabpanel" class="tab-pane fade <?php if($view=='list'){ echo 'active in'; } ?>" id="list">
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
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
                                    
									<?php if($total_number_of_page > 1){ ?>
									
									<div class="pages text-right">
                                        <ul class="pagination">
                                          <li><a class="ajax" data-ajax="<?php if(ceil(@$_GET['p']) > 1){ ?>cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>&p=<?php echo ceil(@$_GET['p'])-1; ?><?php } else{ echo "#";} ?>" href="javascript:void(0)">Prev</a></li>

                                          <?php for($i = 1; $i<=$total_number_of_page; $i++ ){ ?>
                                             <li><a class="active ajax" data-ajax="cat_id=<?php echo $category_id;?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?><?php if($i>1){ ?>&p=<?php echo $i; } ?>" href="javascript:void(0)"><?php echo $i; ?></a></li>

                                            <?php } ?>

                                          <li>
											<a class = "ajax" data-ajax="<?php if(ceil(@$_GET['p']) < $total_number_of_page){ ?>cat_id=<?php echo $category_id; ?>&brand_id=<?php echo ceil(@$_GET['brand_id']);?>&color_id=<?php echo ceil(@$_GET['color_id']);?>&size_id=<?php echo ceil(@$_GET['size_id']);?>&p=<?php if(!isset($_GET['p']))  echo '2'; else{ ?><?php echo ceil(@$_GET['p'])+1; } ?> <?php } else{ echo "#";} ?>" href="javascript:void(0)">Next</a>
										  </li>											  
                                        </ul>
                                    </div>
									<?php } ?>
                                    </div>
                                </div>
                                <input type="hidden" id="view_value" value="<?php echo $view; ?>" />
                                
<script type="text/javascript">

$(document).ready(function(){
    $(".ajax").click(function(){

       var data = $(this).attr('data-ajax');
        var value = $('.changessort').val();
		var show = $('.changeshow').val();
		var amount1 = $('#amount1').val();
		var amount2 = $('#amount2').val();
		
       if(data!='#')
       {
        $("#loader").show(); 
        data = data+'&view=' + $('#view_value').val() + '&position=' + value+'&amount1='+amount1+'&amount2='+amount2+'&sort='+show;
        
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
        var data = cat_id+'&sort=' + value+'&view=' + $('#view_value').val()+'&position=' + pos;
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data: data

        }).done(function(response){
           $("#ajaxContent").html(response);
        });
      
    });
});

// Quick view
$(document).ready(function(){
	
    $(".quick-view").click(function(){
        var product_id = $(this).attr('product-id');

        $.ajax({
            type: "GET",
            url: "secure/ajax_loader.php",
            data:{quick_view:product_id}
        }).done(function(response){
           $("#modal-body").html(response);
        });
    });
});

    // Cart popup
$(document).ready(function(){
     $(".cartpopup").click(function(){
         var product_id = $(this).attr('product-id');

         $.ajax({
           type: "GET",
           url: "secure/ajax_loader.php",
           data:{cart_popup:product_id}
         }).done(function(response){
             $("#cart-body").html(response);
         });
    });
});
	
</script>

