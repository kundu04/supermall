<?php include("fw-config.php"); ?>

<?php
		
		if (isset($_POST['update_product']))
			{
				
				$name 			= $_POST['product_name'];
				$imageName 		= str_replace(' ', '-', $name);
				$fileExtension	= end(explode( ".", $_FILES['main_img']['name'] )); 
				$newImgName		= $imageName. '.' .$fileExtension;
				
				$img_name 		= $_FILES['main_img']['name'];
				$img_type 		= $_FILES['main_img']['type'];
				$img_Size 		= $_FILES['main_img']['size'];
				$img_error 		= $_FILES['main_img']['error'];
				$img_tmp_name 	= $_FILES['main_img']['tmp_name'];
				
				$check_mainImage = $coreControl->checkImage($img_type, $img_Size, $img_error);
				$mainImg_src 	= "uploads/products/".$newImgName;
				
				if($img_name!="" && $check_mainImage==1) {
					
					move_uploaded_file($img_tmp_name, $mainImg_src);
					$proVal["main_image"] = $mainImg_src;
				} 
				
				$proVal["model"] = $_POST['product_model'];
				$proVal["sku"] = $_POST['product_sku'];
				// $proVal["location"] = $_POST[''];
				$proVal["quantity"] = $_POST['product_quantity'];
				$proVal["stock_status_id"] = $_POST['stock_id'];
				$proVal["points"] = $_POST['points'];
				$proVal["manufacturer_id"] = $_POST['brnad_id'];
				$proVal["price"] = $_POST['product_price'];
				// $proVal["date_available"] = $_POST[''];
				$proVal["weight"] = $_POST['weight'];
				$proVal["weight_class_id"] = $_POST['weight_id'];
				$proVal["length"] = $_POST['length'];
				$proVal["width"] = $_POST['width'];
				$proVal["height"] = $_POST['height'];
				$proVal["length_class_id"] = $_POST['length_id'];
				$proVal["sort_order"] = $_POST['sort_order'];
				$proVal["type"] = $_POST['type'];
				$proVal["status"] = $_POST['status'];
				
				$proVal["date_modified"] = date("Y-m-d H:i:s");
				
				$whereValue['product_id'] = $_POST['product_id'];
				$queryPro = $coreModel->updateData("product", $proVal, @$whereValue);
				
				// PRODUCT DESCRIPTION //
				$proDesVal["name"] = $_POST['product_name'];
				$proDesVal["description"] = $_POST['product_des'];
				$proDesVal["tag"] = $_POST['tag'];
				$proDesVal["meta_title"] = $_POST['meta_title'];
				$proDesVal["meta_description"] = $_POST['meta_des'];
				$proDesVal["meta_keyword"] = $_POST['meta_keyword'];
				$queryProDes = $coreModel->updateData("product_description", $proDesVal, @$whereValue);
				
				// PRODUCT TO CATEGORY //
				
				$coreModel->deleteData('product_to_category', @$whereValue);
				
				$catId = $_POST['category_id'];
				for ($i = 0; $i<count($catId); $i++ ) {
					$proCatVal["product_id"] = $_POST['product_id'];
					$proCatVal["category_id"] = $catId[$i];
				$queryProCat =	$coreModel->insertData("product_to_category", $proCatVal);
				}
				
				// RELATED PRODUCT  //
				
				$coreModel->deleteData('product_related', @$whereValue);
				
				$rpId = $_POST['related_product'];
				for ($i = 0; $i<count($rpId); $i++ ) {
					$relproVal["product_id"] = $_POST['product_id'];
					$relproVal["related_id"] = $rpId[$i];
				$queryProrel =	$coreModel->insertData("product_related", $relproVal);
				}
				
				// DISCOUNT //
				// $proDisVal["customer_group_id"] = $_POST[''];
				$proDisVal["quantity"] = $_POST['dis_quantity'];
				$proDisVal["priority"] = $_POST['priority'];
				$proDisVal["price"] = $_POST['dis_price'];
				$proDisVal["date_start"] = $_POST['date_start'];
				$proDisVal["date_end"] = $_POST['date_end'];
				$queryProDis = $coreModel->updateData("product_discount", $proDisVal, @$whereValue);
				
				// COLOR //
				
				$coreModel->deleteData('product_color', @$whereValue);
				
				$colorId = $_POST['color_id'];
				
				for ($i = 0; $i<count($colorId); $i++ ) {
					$proColVal["product_id"] = $_POST['product_id'];
					$proColVal["color_id"] = $colorId[$i];
				
				$queryProCol = $coreModel->insertData("product_color", $proColVal, @$whereValue);
				 }
				
				// SIZE //
				
				$coreModel->deleteData('product_size', @$whereValue);
				
				 $sizeId = $_POST['size_id'];
				 
				 for ($i = 0; $i<count($sizeId); $i++ ) {
					 $proSizeVal["product_id"] = $_POST['product_id'];
					 $proSizeVal["size_id"] = $sizeId[$i];
				
				$queryProSize =  $coreModel->insertData("product_size", $proSizeVal, @$whereValue);
				 }
				
				
				// Sub - image - 1 //
				
				$subImg1_name 		= $_FILES['sub_img1']['name'];
				$subImg1_type 		= $_FILES['sub_img1']['type'];
				$subImg1_size 		= $_FILES['sub_img1']['size'];
				$subImg1_error 		= $_FILES['sub_img1']['error'];
				$subImg1_tmp_name 	= $_FILES['sub_img1']['tmp_name'];
				
				foreach($subImg1_name as $key1 => $value1){
								
					$fileExtension1 	= end(explode( ".", $value1[0] ));	
					$subImgName1 = $imageName . '-1.'. $fileExtension1;		
					
					//$check_subImage1 = $coreControl->checkImage($subImg1_type, $subImg1_size, $subImg1_error);
					$source1 = "uploads/products/subimages/".$subImgName1;
					 
					if($value1[0] != ""){
						move_uploaded_file($subImg1_tmp_name[$key1][0], $source1);
						$imgValue1['image'] = $source1;
						$whereImgValue1['product_image_id'] = $key1;
					$querySubImg1 =	$coreModel->updateData("product_image", $imgValue1, @$whereImgValue1);
					}
				}
				
				// Sub - image - 2 //
				
				$subImg2_name 		= $_FILES['sub_img2']['name'];
				$subImg2_type 		= $_FILES['sub_img2']['type'];
				$subImg2_size 		= $_FILES['sub_img2']['size'];
				$subImg2_error 		= $_FILES['sub_img2']['error'];
				$subImg2_tmp_name 	= $_FILES['sub_img2']['tmp_name'];
				
				foreach($subImg2_name as $key2 => $value2){
								
					$fileExtension2 	= end(explode( ".", $value2[0] ));	
					$subImgName2 = $imageName . '-2.'. $fileExtension2;		
					
					//$check_subImage2 = $coreControl->checkImage($subImg1_type, $subImg1_size, $subImg1_error);
					$source2 = "uploads/products/subimages/".$subImgName2;
					 
					if($value2[0] != ""){
						move_uploaded_file($subImg2_tmp_name[$key2][0], $source2);
						$imgValue2['image'] = $source2;
						$whereImgValue2['product_image_id'] = $key2;
					$querySubImg2 =	$coreModel->updateData("product_image", $imgValue2, @$whereImgValue2);
					}
				}
				
				// Sub - image - 3 //
				
				$subImg3_name 		= $_FILES['sub_img3']['name'];
				$subImg3_type 		= $_FILES['sub_img3']['type'];
				$subImg3_size 		= $_FILES['sub_img3']['size'];
				$subImg3_error 		= $_FILES['sub_img3']['error'];
				$subImg3_tmp_name 	= $_FILES['sub_img3']['tmp_name'];
				
				foreach($subImg3_name as $key3 => $value3){
								
					$fileExtension3 	= end(explode( ".", $value3[0] ));	
					$subImgName3 = $imageName . '-3.'. $fileExtension3;		
					
					//$check_subImage3 = $coreControl->checkImage($subImg1_type, $subImg1_size, $subImg1_error);
					$source3 = "uploads/products/subimages/".$subImgName3;
					 
					if($value3[0] != ""){
						move_uploaded_file($subImg3_tmp_name[$key3][0], $source3);
						$imgValue3['image'] = $source3;
						$whereImgValue3['product_image_id'] = $key3;
					$querySubImg3 =	$coreModel->updateData("product_image", $imgValue3, @$whereImgValue3);
					}
				}
				
				
				
				
				if ($queryColor > 0 || $queryProDes > 0 || $queryProCat > 0 || $queryProDis > 0 || $queryProCol > 0 || $queryProSize > 0 || $querySubImg1 > 0 || $querySubImg2 > 0 || $querySubImg3 > 0 ){ 
					
					$_SESSION['mgs']= '
						<div class="alert alert-success alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<h4>
								<i class="icon-ok-sign"></i>
								Success!
							</h4>
							<p>You have successfully updated the product named <strong>'.$_POST['product_name'].'</strong>.</p>
						</div> 
					';
					header("Location:product-list");
					
				}
				else{	
					$_SESSION['mgs'] = '
						<div class="alert alert-danger alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<h4>
								<i class="icon-ok-sign"></i>
								Sorry!
							</h4>
							<p>You have not updated the Product named <strong>'.$name.'</strong>.</p>
						</div> 
					';
					header("Location:product-edit.php?id=".$_POST['product_id']);
				}
			
			
			}
			
			?>