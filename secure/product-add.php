<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>
<?php
function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '', $panetName='') 
{
	if (!is_array($category_tree_array))
	$category_tree_array = array();
    global $coreModel;
	$data = $coreModel->selectData('*', 'category', array('parent_id'=>$parent));

	foreach($data as $value) {
		$category_tree_array[] = array("category_id" => $value['category_id'], "cat_name" => $panetName.$spacing . $value['cat_name']);
		$category_tree_array = categoryParentChildTree($value['category_id'], $spacing . '-&nbsp;', $category_tree_array, $panetName.$spacing . ''.$value['cat_name']);
	}
	return $category_tree_array;
}
$categoryList = $coreModel->selectData('*', 'category', array('status'=>'Active'));
?>
		<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Products
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="product-list.php">Product</a>
                </li>
                <li class="active">Add Products</li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
			<div class="row">
			
			<!--success notification-->
			<div class="col-md-12">
			<?php
			
			if (isset($_POST['add_product']))
			{
				$name = $_POST['product_name'];
	            $photoName = str_replace(' ', '-', $name);
	            $myExtension = array("jpg", "png", "jpeg", "gif");
	            $filenameArray = explode( ".", $_FILES['main_image']['name'] ); 
	            $fileExtension = end($filenameArray); 
	            $folderName = "uploads/products/";

	            if (($_FILES['main_image']['error'] == 0) &&
	                in_array($fileExtension, $myExtension) &&
	                ($_FILES['main_image']['size'] < 999999)
	                ) {
	                $temporarUploadedFile = $_FILES['main_image']['tmp_name'];
	                $filesNewName = $photoName . '.'. $fileExtension;
	                $finalDestination = $folderName . $filesNewName;
	                $proVal["main_image"] = $finalDestination;
	                move_uploaded_file($temporarUploadedFile, $finalDestination);
	            }

	            $filenameArray1 = explode( ".", $_FILES['sub_image1']['name'] ); 
	            $filenameArray2 = explode( ".", $_FILES['sub_image2']['name'] ); 
	            $filenameArray3 = explode( ".", $_FILES['sub_image3']['name'] ); 
	            $fileExtension1 = end($filenameArray1); 
	            $fileExtension2 = end($filenameArray2); 
	            $fileExtension3 = end($filenameArray3); 
	            $subFolderName = "uploads/products/subimages/";

	            if (($_FILES['sub_image1']['error'] == 0) &&
	                in_array($fileExtension1, $myExtension) &&
	                ($_FILES['sub_image1']['size'] < 999999)
	                ) {
	                $temporarUploadedFile1 = $_FILES['sub_image1']['tmp_name'];
	                $filesNewName1 = $photoName . '-1' . '.'. $fileExtension1;
	                $finalDestination1 = $subFolderName . $filesNewName1;
	                $subImg1 = $finalDestination1;
	                move_uploaded_file($temporarUploadedFile1, $finalDestination1);
	            }
	            if (($_FILES['sub_image2']['error'] == 0) &&
	                in_array($fileExtension2, $myExtension) &&
	                ($_FILES['sub_image2']['size'] < 999999)
	                ) {
	                $temporarUploadedFile2 = $_FILES['sub_image2']['tmp_name'];
	                $filesNewName2 = $photoName . '-2' . '.'. $fileExtension2;
	                $finalDestination2 = $subFolderName . $filesNewName2;
	                $subImg2 = $finalDestination2;
	                move_uploaded_file($temporarUploadedFile2, $finalDestination2);
	            }
	            if (($_FILES['sub_image3']['error'] == 0) &&
	                in_array($fileExtension3, $myExtension) &&
	                ($_FILES['sub_image3']['size'] < 999999)
	                ) {
	                $temporarUploadedFile3 = $_FILES['sub_image3']['tmp_name'];
	                $filesNewName3 = $photoName . '-3' . '.'. $fileExtension3;
	                $finalDestination3 = $subFolderName . $filesNewName3;
	                $subImg3 = $finalDestination3;
	                move_uploaded_file($temporarUploadedFile3, $finalDestination3);
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
				$proVal["status"] = $_POST['status'];
				// $proVal["viewed"] = $_POST[''];
				// $proVal["date_added"] = $_POST[''];
				// $proVal["date_modified"] = $_POST[''];
				
				$queryPro = $coreModel->insertData("product", $proVal);
				$productId = $queryPro['last_insert_id'];
				// sub images
				$coreModel->insertData("product_image", array("product_id"=> $productId, "image"=> $subImg1));
				$coreModel->insertData("product_image", array("product_id"=> $productId, "image"=> $subImg2));
				$coreModel->insertData("product_image", array("product_id"=> $productId, "image"=> $subImg3));

               
				// PRODUCT DESCRIPTION //
				$proDesVal["product_id"] = $productId;
				$proDesVal["name"] = $_POST['product_name'];
				$proDesVal["description"] = $_POST['product_des'];
				$proDesVal["tag"] = $_POST['tag'];
				$proDesVal["meta_title"] = $_POST['meta_title'];
				$proDesVal["meta_description"] = $_POST['meta_des'];
				$proDesVal["meta_keyword"] = $_POST['meta_keyword'];
				$coreModel->insertData("product_description", $proDesVal);
				
				// PRODUCT TO CATEGORY //
				$catId = $_POST['product_category'];
				for ($i = 0; $i<count($catId); $i++ ) {
					$proCatVal["product_id"] = $productId;
					$proCatVal["category_id"] = $catId[$i];
					$coreModel->insertData("product_to_category", $proCatVal);
				}
				
				// RELATED PRODUCT //
				$relatedProId = $_POST['related_product'];
				for ($i = 0; $i<count($relatedProId); $i++ ) {
					$relatedProVal["product_id"] = $productId;
					$relatedProVal["related_id"] = $relatedProId[$i];
					$coreModel->insertData("product_related", $relatedProVal);
				}
				
				// DISCOUNT //
				$proDisVal["product_id"] = $productId;
				// $proDisVal["customer_group_id"] = $_POST[''];
				$proDisVal["quantity"] = $_POST['dis_quantity'];
				$proDisVal["priority"] = $_POST['priority'];
				$proDisVal["price"] = $_POST['dis_price'];
				$proDisVal["date_start"] = $_POST['date_start'];
				$proDisVal["date_end"] = $_POST['date_end'];
				$coreModel->insertData("product_discount", $proDisVal);
				
				// COLOR //
				$colorId = $_POST['color_id'];
				for ($i = 0; $i<count($colorId); $i++ ) {
					$proColVal["product_id"] = $productId;
					$proColVal["color_id"] = $colorId[$i];
					$coreModel->insertData("product_color", $proColVal);
				}
				
				// SIZE //
				$sizeId = $_POST['size_id'];
				for ($i = 0; $i<count($sizeId); $i++ ) {
					$proSizeVal["product_id"] = $productId;
					$proSizeVal["size_id"] = $sizeId[$i];
					$coreModel->insertData("product_size", $proSizeVal);
				}
				
				if (!$queryPro)
					echo '
						<div class="alert alert-danger alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<h4>
								<i class="icon-ok-sign"></i>
								Sorry!
							</h4>
							<p>You have not inputed Product name. Please input Product name.</p>
						</div> 
					';
				else
				{
					echo '
						<div class="alert alert-success alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<h4>
								<i class="icon-ok-sign"></i>
								Success!
							</h4>
							<p>You have successfully added the product named <strong>'.$_POST['product_name'].'</strong>. &nbsp;
								<a class="btn btn-primary btn-xs" href="product-list.php" >View</a>
							</p>
						</div> 
					';
				}
			}
			
			?>
			</div>
			<!--success notification-->
			
			<form role="form" method="Post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
			
			<div class="col-md-8">
			<section class="panel">
					<header class="panel-heading">
						Product Details
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						 </span>
					</header>
					<div class="panel-body">
						<div class="form-group">
                            <label>Product Title <span class="star">*</span></label>
                            <input required type="text" name="product_name" class="form-control" placeholder="Enter your product title" />
                        </div><br/>
						
						<div class="form-group">
							<label>Product Description <span class="star">*</span></label>
                            <textarea name="product_des" class="wysihtml5 form-control" rows="5" placeholder="Write description..." ></textarea>
                        </div><br/>
					</div>
				</section>
				<!-- title & description -->
				<section class="panel">
					<header class="panel-heading">
						Category 
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 cat">
								<div>
								  <label for="birds">Category: <span class="star">*</span></label>
								  <input id="category_name_for_search"  class="form-control">
								</div>
								<br />
								<div id="product-category" class="well well-sm" style="height: 120px; overflow: auto;">
								</div>
							</div>
						</div>
						
						<div id="saveText">
						
						</div>
						
						<input type="hidden" name="category_id_list" id="category_id_list" value="" />
						<div class="panel-group " id="accordion">
							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										<h6 class="panel-title">Create New Category</h6>
									</a>
								</div>
								<div id="collapseOne" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="form-group form-horizontal">
											<input id="catInput" name="catInput" type="text" class="form-control" placeholder="Enter New Category"/>
											<br />
											<select id="catParent" name="catParent" class="form-control">
												<option value="0" >No -parent</option>
												<?php
												$queryCat = $coreModel->SelectData("*", "category", array("parent_id" => 0) );
												foreach($queryCat as $catList){
												?>
												<option style="font-weight:bold;" value="<?php echo $catList["category_id"];?>"> <?php echo $catList["cat_name"];?></option>
													<?php
													$querysCat = $coreModel->SelectData("*", "category", array("parent_id" => $catList["category_id"]) );
													foreach($querysCat as $scatList){
													?>
													<option value="<?php echo $scatList["category_id"];?>"> &rarr;<?php echo $scatList["cat_name"];?></option>
														<?php
														$queryssCat = $coreModel->SelectData("*", "category", array("parent_id" => $scatList["category_id"]) );
														foreach($queryssCat as $sscatList){
														?>
														<option value="<?php echo $sscatList["category_id"];?>"> &rarr;&rarr;<?php echo $sscatList["cat_name"];?></option>
															<?php
															$querysssCat = $coreModel->SelectData("*", "category", array("parent_id" => $sscatList["category_id"]) );
															foreach($querysssCat as $ssscatList){
															?>
															<option value="<?php echo $ssscatList["category_id"];?>"> &rarr;&rarr;&rarr;<?php echo $ssscatList["cat_name"];?></option>
															<?php } ?>
														<?php } ?>
													<?php } ?>
												<?php } ?>
												
											</select>
											<br />
											<input type="button" id="addCat" onClick="addCategory();" name="addCat" class="btn btn-success btn-sm" value="Add New" />
											<div id="addMsg"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!--END CATEGORY -->
				<section class="panel">
					<header class="panel-heading">
						Product Images
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<div class="col-md-3 form-group">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Main Image <span class="star">*</span></label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<img src="images/no-image.png" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
								<span class="fileupload-exists"> Change</span>
								<input name="main_image" type="file" class="default" />
									</span>
									<a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
								</div>
							</div>
						</div> 
						
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub Image 1</label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<img src="images/no-image.png" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
								<span class="fileupload-exists"> Change</span>
								<input name="sub_image1" type="file" class="default" />
									</span>
									<a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
								</div>
							</div>
						</div> 
						
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub Image 2</label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<img src="images/no-image.png" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
								<span class="fileupload-exists"> Change</span>
								<input name="sub_image2" type="file" class="default" />
									</span>
									<a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
								</div>
							</div>
						</div> 
						
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub Image 3</label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<img src="images/no-image.png" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
								<span class="fileupload-exists"> Change</span>
								<input name="sub_image3" type="file" class="default" />
									</span>
									<a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
								</div>
							</div>
						</div> 
					</div>
				</section>
				<!--END Image -->
				
				<!--Related Products -->
				<section class="panel">
					<header class="panel-heading">
						Related Product 
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 cat">
								<div>
								  <label for="birds">Related Products: <span class="star">*</span></label>
								  <input id="related_name_for_search"  class="form-control">
								</div>
								<br />
								<div id="related-product" class="well well-sm" style="height: 120px; overflow: auto;">
								
								</div>
							</div>
						</div>
					</div>
				</section>
				<!--End Related Products -->
				
				<section class="panel">
                    <header class="panel-heading">
                        SEO
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
					<div class="panel-body">
						<div class="form-group">
                            <label>Meta Title <span class="star">*</span></label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Enter your product title" />
                        </div>
					
						<div class="form-group ">
                            <label class="control-label" >Meta Description</label>
                            <textarea name="meta_des" class="form-control" placeholder="Write content for seo..." rows="3" ></textarea>
                        </div>
						<div class="form-group ">
                            <label class="control-label" >Meta Keyword</label>
                            <textarea name="meta_keyword" class="form-control" placeholder="Write content for seo..." rows="3" ></textarea>
                        </div>
						
						<div class="form-group">
							<label>Insert Tags</label>
							<input name="tag" id="tags_1" type="text" class="tags" placeholder="insert tags with comma" />
						</div>
						
					</div>
				</section>
				<!-- SEO -->
				
			</div>
			<!--col-8-->
				
			<div class="col-md-4">
				
				<section class="panel">
                    <header class="panel-heading">
                        Product Info
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
					
					<div class="panel-body form-horizontal">
						<div class="form-group">
							<label class="col-xs-4 control-label" >Model <span class="star">*</span></label>
							<div class="col-xs-8">
							<input type="text" name="product_model" class="form-control" placeholder="Enter Product Model" required />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >SKU <span class="star">*</span></label>
							<div class="col-xs-8">
							<input type="text" name="product_sku" class="form-control" placeholder="Enter Product SKU" required />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Quantity <span class="star">*</span></label>
							<div class="col-xs-8">
							<input type="text" name="product_quantity" class="form-control" placeholder="Enter Product Quantity" required />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Stock <span class="star">*</span></label>
							<div class="col-xs-8">
								<select name="stock_id" class="form-control" required>
									
									<?php 
									$stock = $coreModel->SelectData("*", "stock_status");
									
									foreach($stock as $stockStatus){ ?>
									
									<option <?php if($stockStatus['stock_name']=="Available"){ echo "selected='selected'"; } ?>
									
									value="<?php echo $stockStatus['stock_status_id']; ?>"><?php echo $stockStatus['stock_name']; ?></option>
									
									<?php } ?>
									
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Price <span class="star">*</span></label>
							<div class="col-xs-8">
							<input type="text" name="product_price" class="form-control" placeholder="Enter Product Price" required />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Brand <span class="star">*</span></label>
							<div class="col-xs-8">
								<select id="brand" name="brnad_id" class="form-control" required>
									<option value="">Select Brand</option>
									
									<?php 
									$brand = $coreModel->SelectData("*", "manufacturer");
									foreach($brand as $brandList){ ?>
									
									<option value="<?php echo $brandList['manufacturer_id']; ?>"><?php echo $brandList['brand_name']; ?></option>
									
									<?php }	?>
									
								</select>
							</div>
						</div>
					
					</div>
				</section>
				<!-- Info -->

				<section class="panel">
					<header class="panel-heading">
						Color 
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 color">
								<select multiple="multiple" name="color_id[]" class="selectColor">
									
									<?php
									$queryColor = $coreModel->SelectData("*", "color");
									foreach($queryColor as $colorList){
										echo '
											<option value="'.$colorList["color_id"].'">'.$colorList["color_name"].'</option>
										';
									}
									?>
								</select>
								<input id="colorInput" type="text" class="form-control" placeholder="Enter New Color"/><br/>
								<input type="button" onClick="addColor();" class="btn btn-success btn-sm" value="Add New" />
								<div id="addColorMsg"></div>
								
							</div>
						</div>
						
					
						
					</div>
				</section>
				<!-- Color -->
				
				<section class="panel">
					<header class="panel-heading">
						Size 
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 size">
								<select multiple="multiple" name="size_id[]" class="selectSize">
									<?php
									$querySize = $coreModel->SelectData("*", "size");
									foreach($querySize as $sizeList){
										echo '
											<option value="'.$sizeList["size_id"].'">'.$sizeList["size_name"].'</option>
										';
									}
									?>
								</select>
								<input id="sizeInput" type="text" class="form-control" placeholder="Enter New Size"/><br/>
								<input type="button" onClick="addSize();" class="btn btn-success btn-sm" value="Add New" />
								<div id="addSizeMsg"></div>
							</div>
						</div>					
					</div>
				</section>
				<!-- Size -->
				
				<section class="panel">
                    <header class="panel-heading">
                        Product dimention
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-up"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
					<div style="display: none;" class="panel-body form-horizontal" >
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Weight </label>
							<div class="col-xs-4">
								<input type="text" name="weight" class="form-control" placeholder="Enter Product Weight"/>
							</div>
							<div class="col-xs-4">
								<select id="weight_id" name="weight_id" class="form-control">
									<option value="" >Select</option>
									<?php 
									$queryWeight = $coreModel->SelectData("*", "weight_class");
									foreach($queryWeight as $weightList){
										echo '
										<option value="'.$weightList['weight_class_id'].'">'.$weightList['weight_class_name'].'</option>
										';
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" >Dimensions </label>
							<div class="col-xs-8">
								<input type="text" name="length" class=" form-control" placeholder="Enter Product Length"/>
							</div>
							<div class="col-xs-offset-4 col-xs-8">
								<input type="text" name="width" class=" form-control" placeholder="Enter Product Width"/>
							</div>
							<div class="col-xs-offset-4 col-xs-8">
								<input type="text" name="height" class=" form-control" placeholder="Enter Product Height"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" >Length Class </label>
							<div class="col-xs-8">
								<select id="weight_id" name="length_id" class="form-control">
									<option value="" >Select Length </option>
									<?php 
									$queryLength = $coreModel->SelectData("*", "length_class");
									foreach($queryLength as $lengthList){
										echo '
										<option value="'.$lengthList['length_class_id'].'">'.$lengthList['length_class_name'].'</option>
										';
									}
									?>
								</select>
							</div>
						</div>
						
					</div>
				</section>
				<!-- Dimensions -->
				
                <section class="panel">
					<header class="panel-heading">
						Price & Discount
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-up"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
                    <div style="display: none;" class="panel-body form-horizontal">
						<div id="discount">
						<h4><span class="label label-warning">Discount 1</span></h4>
						<div class="form-group">
							<label class="col-xs-4 control-label" for="price">Dis. Price</label>
							<div class="col-xs-8">
								<input class="form-control" name="dis_price" placeholder="Enter After Discount Price" type="number"/>
							</div>
						</div>
					
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Dis. Unit</label>
                            <div class="col-xs-8">
                                <input class="form-control" name="dis_quantity" placeholder="Enter Discount Quantity" type="number"/>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Points</label>
                            <div class="col-xs-8">
                                <input class="form-control" name="points" placeholder="Enter Points" type="number"/>
                            </div>
                        </div>
					
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Dis. Priority</label>
                            <div class="col-xs-8">
                                <select name="priority" class="form-control">
									<option value="0">Off</option>
									<option value="1">On</option>
								</select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-xs-4 control-label" >Dis. Start </label>
                            <div class="col-xs-8">
                              <input class="form-control" name="date_start" placeholder="YYYY/MM/DD" type="date"/>
                            </div>
                        </div>
					
						<div class="form-group ">
                            <label class="col-xs-4 control-label" >Dis. End </label>
                            <div class="col-xs-8">
                              <input class="form-control" name="date_end" placeholder="YYYY/MM/DD" type="date"/>
                            </div>
                        </div>
						
						</div>
						<div id="append_discount"></div>
						<input type="button" onClick="appendDiscount()" class="btn btn-success" value="Add More Discount" />
						
                    </div>
                </section>
				<!-- DISCOUNT -->
				
				<section class="panel">
					<header class="panel-heading">
						Published
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						 </span>
					</header>
					<div class="panel-body form-horizontal">
						
						<div class="form-group">
                            <label class="col-xs-6 control-label" for="productsku">Sort Order :</label>
							<div class="col-xs-6">
								<input type="text" name="sort_order" class=" form-control" placeholder="Enter Sort Order" />
							</div>
                        </div>
						<div class="form-group">
                            <label class="col-xs-6 control-label" for="productType">Product Type :</label>
							<div class="col-xs-6">
								<select name="type" class="form-control">
									<option>General</option>
									<option>Featured</option>
								</select>
							</div>
                        </div>
						<div class="form-group">
                            <label class="col-xs-6 control-label" for="productsku">Product Status :</label>
							<div class="col-xs-6">
								<select name="status" class="form-control">
									<option>Active</option>
									<option>Inactive</option>
								</select>
							</div>
                        </div>
						<button type="submit" name="add_product" class="btn btn-success">Add Product</button>
						<button type="reset" name="reset" class="btn btn-warning">Reset</button>
						<a href="product-list.php" class="btn btn-danger">Cancel</a>
						
						
					</div>
				</section>
				<!-- PUBLISHED -->
				
				
			</div>
			<!--col-4-->
			</form>
			</div>
			<!--row-->

        </div>
        <!--body wrapper end-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
var i = 0;
function appendDiscount() {
	i++;
    var discount = $("#discount").html()+'<input type="button" onClick="remove()" class="btn btn-success" value="Delete" />';
	
    $("#append_discount").append(discount);
}


function addCategory() {
	
	var cat_name = $('#catInput').val();
	var cat_parent_id = $('#catParent').val();
	
    if (cat_name.length == '') { 
        document.getElementById("addMsg").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showCategory").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_loader.php?cat_name=" + cat_name+"&parent_id=" + cat_parent_id , true);
        xmlhttp.send();
    }
	
}

function addColor() {
	
	var color_name = $('#colorInput').val();
	
    if (color_name.length == '') { 
        document.getElementById("addColorMsg").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("addColorMsg").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_loader.php?color_name=" + color_name , true);
        xmlhttp.send();
    }
	
}
function addSize() {
	
	var size_name = $('#sizeInput').val();
	
    if (size_name.length == '') { 
        document.getElementById("addSizeMsg").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("addSizeMsg").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_loader.php?size_name=" + size_name , true);
        xmlhttp.send();
    }
	
}


</script>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
  $( function() {
    
    $( "#category_name_for_search" ).autocomplete({
		source: "search.php",
		minLength: 2,
		select: function( event, ui ) {
			$('#product-category' + ui.item.id).remove();
			$('#product-category').append('<div id="product-category' + ui.item.id + '"><i title="Remove" class="fa fa-times-circle"></i> ' + ui.item.value + '<input type="hidden" name="product_category[]" value="' + ui.item.id + '" /></div>');
			$('#category_name_for_search').val("");
			$('#category_name_for_search').val() = '';	
		},
    });

    $('#product-category').delegate('.fa-times-circle', 'click', function() {
		$(this).parent().remove();
	});
  } );
</script>
  
<script>
  $( function() {
    
    $( "#related_name_for_search" ).autocomplete({
		source: "search-related.php",
		minLength: 2,
		select: function( event, ui ) {
			$('#related-product' + ui.item.id).remove();
			$('#related-product').append('<div id="related-product' + ui.item.id + '"><i title="Remove" class="fa fa-times-circle"></i> ' + ui.item.value + '<input type="hidden" name="related_product[]" value="' + ui.item.id + '" /></div>');
			$('#related_name_for_search').val("");
			$('#related_name_for_search').val() = '';	
		},
    });

    $('#related-product').delegate('.fa-times-circle', 'click', function() {
		$(this).parent().remove();
	});
  } );
</script>