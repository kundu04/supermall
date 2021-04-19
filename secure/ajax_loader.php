<?php include("fw-config.php") ?>
<?php 
function splitWord($text, $limit=300)
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
// delete product main image
if (isset($_REQUEST['del_main_image']))
{
    $tableName = "product";
    $columnValue["main_image"] = '';
    $whereValue["product_id"] = $_REQUEST['del_main_image'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete product sub image 1
if (isset($_REQUEST['del_sub_image1']))
{
    $tableName = "product_image";
    $columnValue["image"] = '';
    $whereValue["product_image_id"] = $_REQUEST['del_sub_image1'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete product sub image 2
if (isset($_REQUEST['del_sub_image2']))
{
    $tableName = "product_image";
    $columnValue["image"] = '';
    $whereValue["product_image_id"] = $_REQUEST['del_sub_image2'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete product sub image 3
if (isset($_REQUEST['del_sub_image3']))
{
    $tableName = "product_image";
    $columnValue["image"] = '';
    $whereValue["product_image_id"] = $_REQUEST['del_sub_image3'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete category logo
if (isset($_REQUEST['del_cat_logo']))
{
    $tableName = "category";
    $columnValue["logo"] = '';
    $whereValue["category_id"] = $_REQUEST['del_cat_logo'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete category banner
if (isset($_REQUEST['del_cat_banner']))
{
    $tableName = "category";
    $columnValue["banner"] = '';
    $whereValue["category_id"] = $_REQUEST['del_cat_banner'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete banner
if (isset($_REQUEST['del_banner_image']))
{
    $tableName = "banner";
    $columnValue["image"] = '';
    $whereValue["banner_id"] = $_REQUEST['del_banner_image'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
// delete slider
if (isset($_REQUEST['del_slider_image']))
{
    $tableName = "slider";
    $columnValue["image"] = '';
    $whereValue["slider_id"] = $_REQUEST['del_slider_image'];
    $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
}
/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_REQUEST["cat_name"])) 
 {  
    $tableName = "category";
	$columnValue["cat_name"] = $_REQUEST['cat_name'];
	$columnValue["parent_id"] = $_REQUEST['parent_id'];
	
	$queryResult = $coreModel->insertData($tableName, $columnValue);
	
	if($queryResult){
		 echo "Added Category <b>".$_REQUEST["cat_name"]."</b>";
	 }
	 else{
		 echo "Failed Input Category";
	 }
	 
 }
 
if(isset($_REQUEST["color_name"])) 
 {  
    $tableName = "color";
	$columnValue["color_name"] = $_REQUEST['color_name'];
	
	$color = $coreModel->insertData($tableName, $columnValue);
	
	 if($color){
		 echo "Added Color <b>".$_REQUEST["color_name"]."</b>";
	 }
	 else{
		 echo "Failed Input Color";
	 }
 }
 
if(isset($_REQUEST["size_name"])) 
 {  
    $tableName = "size";
	$columnValue["size_name"] = $_REQUEST['size_name'];
	
	$size = $coreModel->insertData($tableName, $columnValue);
	
	 if($size){
		 echo "Added size <b>".$_REQUEST["size_name"]."</b>";
	 }
	 else{
		 echo "Failed Input size";
	 }
 }
?>
<?php
if($_REQUEST['get_cityList'])
{
	$columnName = "*";
	$tableName = "city";
	$whereValue['country_id'] = $_REQUEST['get_cityList'];
	
	$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
		echo '<option value="">Select City</option>';	
	foreach($queryResult AS $eachRow)
	{
		echo '<option value="'.$eachRow['city_id'].'">'.$eachRow['name'].'</option>';
	}
}
?>
<?php
if($_REQUEST['get_ship_cityList'])
{
	$columnName = "*";
	$tableName = "city";
	$whereValue['country_id'] = $_REQUEST['get_ship_cityList'];
	
	$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
		echo '<option value="">Select City</option>';
	foreach($queryResult AS $eachRow)
	{
		echo '<option value="'.$eachRow['city_id'].'">'.$eachRow['name'].'</option>';
	}
}
?>
<?php
 if(isset($_REQUEST["quick_view"])) 
 {
    $productId = $_REQUEST['quick_view'];
    
    $products = $myModel->customQuery("SELECT p.*,pd.*, prd.price as dis_price FROM product as p
    left join product_description as pd ON p.product_id = pd.product_id
    left join product_discount as prd ON  p.product_id = prd.product_id 
    WHERE p.product_id = '$productId'");
    foreach($products as $product);
	
	if($product['dis_price'] > 0){
		$price = $product['dis_price'];
		$oldprice = 'BDT: '.$product['price'];
	}else{
		$price = $product['price'];
		$oldprice = " ";
	}
	
	$product_color = $myModel->customQuery("SELECT * FROM product_color, color 
	WHERE product_color.color_id = color.color_id AND  product_id='$productId'");
	$product_size = $myModel->customQuery("SELECT * FROM product_size, size 
	WHERE product_size.size_id = size.size_id AND  product_id='$productId'");

?>
    
    <div class="modal-product">
        <div class="product-images">
            <div class="main-image images">
                <img alt="" src="secure/<?php echo $product['main_image']; ?>">
            </div>
        </div>
        <div class="product-info">
            <h1> <a href="product-details.php?product_id=<?php echo $product["product_id"]; ?>"><?php echo $product['name']; ?></a> </h1>
            <div class="price-box-3">
                <div class="s-price-box">
                    <span class="new-price"><?php echo "BDT: ".$price ?></span>
                    <span class="old-price"><?php echo $oldprice; ?></span>
                </div>
            </div>
			
		<form method="post" action="">			
			<div class="row quick-desc">
			
                <?php if(count($product_color) > 0){ ?>
				<div class="col-md-6  col-sm-6 col-xs-12 col-lg-6">
					<label>Color</label>
                    <select name="color" id="color" class="form-control" required>
						<option value="">Choose Color</option>
							<?php foreach($product_color as $color){ ?>
						<option value="<?php echo $color['color_id']; ?>"><?php echo $color['color_name']; ?></option>
							<?php } ?>
					</select>
					<div style="color:#F45C5D" id="showmsgC"></div>
				</div>
				<?php } ?>
				<?php if(count($product_size) > 0){ ?>
				<div class="col-md-6  col-sm-6 col-xs-12 col-lg-6">
					<label>Size</label>
					<select name="size" id="size" class="form-control" required>
						<option value="">Choose Size</option>
							<?php foreach($product_size as $size){ ?>
						<option value="<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></option>
							<?php } ?>
					</select>
					<div style="color:#F45C5D" id="showmsgS"></div>
				</div>
				<?php } ?>
            
			</div>
			
            <div class="quick-add-to-cart">
                    <div class="numbers-row">
                    <input type="number" id="proQnt" value="1" min="1" />
                    </div>
                    <button class="single_add_to_cart_button" type="button" onclick="addToCart(<?php echo $product['product_id']; ?>, 0, <?php echo $price; ?>, 'color', 'size')">Add to cart</button>
            </div>			
		</form>
			
            <div class="quick-desc"><?php echo splitWord($product['description'], 120);?></div>
            <div class="social-sharing">
                <div class="widget widget_socialsharing_widget">
                    <h3 class="widget-title-modal">Share this product</h3>
                    <ul class="social-icons">
                        <li><a target="_blank" title="Facebook" href="#" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
                        <li><a target="_blank" title="Twitter" href="#" class="twitter social-icon"><i class="fa fa-twitter"></i></a></li>
                        <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i class="fa fa-pinterest"></i></a></li>
                        <li><a target="_blank" title="Google +" href="#" class="gplus social-icon"><i class="fa fa-google-plus"></i></a></li>
                        <li><a target="_blank" title="LinkedIn" href="#" class="linkedin social-icon"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php
 if(isset($_REQUEST["cart_popup"])) 
 {
    $productId = $_REQUEST['cart_popup'];
    
    $products = $myModel->customQuery("SELECT p.*,pd.name, prd.price as dis_price FROM product as p
    left join product_description as pd ON p.product_id = pd.product_id
    left join product_discount as prd ON  p.product_id = prd.product_id 
    WHERE p.product_id = '$productId'");
    foreach($products as $product);
	
	if($product['dis_price'] > 0){
		$price = $product['dis_price'];
		$oldprice = 'BDT: '.$product['price'];
	}else{
		$price = $product['price'];
		$oldprice = " ";
	}
	
	$product_color = $myModel->customQuery("SELECT * FROM product_color, color 
	WHERE product_color.color_id = color.color_id AND  product_id='$productId'");
	$product_size = $myModel->customQuery("SELECT * FROM product_size, size 
	WHERE product_size.size_id = size.size_id AND  product_id='$productId'");

?>
    <div class="modal-product">
       <div class="cart-popup"> 
        <div class="product-info cart-popup">
            <h1> <a><?php echo $product['name']; ?></a> </h1>
            <div class="price-box-3">
                <div class="s-price-box">
                    <span class="price"><?php echo "Price  BDT: ".$price ?></span>
                    
                </div>
            </div>
					
			<div class="row quick-desc">
			 
                <?php if(count($product_color) > 0){ ?>
				<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
					
                    <select name="color" id="color" class="form-control" required>
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
					
					<select name="size" id="size" class="form-control" required>
						<option value="">Choose Size</option>
							<?php foreach($product_size as $size){ ?>
						<option value="<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></option>
							<?php } ?>
					</select>
					<div style="color:#F45C5D" id="showmsgS"></div>
				</div>
				<?php } ?>
            
			</div>
			
            <div class="quick-add-to-cart">
				<div class="numbers-row">
					<input type="number" id="proQnt" value="1" min="1" />
                </div>
					<button class="single_add_to_cart_button" type="button" onclick="addToCart(<?php echo $product['product_id']; ?>, 0, <?php echo $price; ?>, 'color', 'size')">Add to cart</button>
            </div>
            
        </div>
       </div>
    </div>

<?php } ?>
<?php

// Wishlist pro add
	if(isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] !==""){
		
		$_SESSION['wishlist_product_id'] = $_REQUEST['pro_id'];
		
		if(isset($_SESSION['cust_id']) && $_SESSION['cust_id']!=''){
			
		$pro_id = ceil($_REQUEST['pro_id']);
		$cust_id = ceil($_SESSION['cust_id']);
		
		$stmt = $coreModel->insertData("customer_wishlist", array("customer_id"=>$cust_id, "product_id"=>$pro_id));
		
		echo "Success";
		}
	else{
		echo "Failed";
	}
	}
	
?>
<?php
// get order id for change order status
if($_REQUEST['get_order_id'])
{
	$tableName = "order";
    $columnName["0"] = "order_status_id";
	$whereVal['order_id'] = $_REQUEST['get_order_id'];
	
	$result = $coreModel->selectData($columnName, $tableName, $whereVal);
	
	$order_status = $myModel->customQuery("SELECT order_status.* FROM order_status");
	
	foreach($order_status AS $status)
	{
		if($result[0]['order_status_id'] == $status['order_status_id']){
			$selected = "selected='selected'";
		} else { $selected = "";}
		
	echo '<option value="'.$status['order_status_id'].'" '.$selected.'>'.$status['name'].'</option>';
		
	}
	
}
?>