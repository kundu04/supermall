<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<?php
	//product Category Tree
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
	//product Main Image
	if(isset($_GET['id']) ) 
	{
		$product = $coreModel->selectData("*", "product", array("product_id"=> $_GET['id'] ) );
		foreach($product as $productList);
			if ($productList['main_image'] == '') {
				$mainImage = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
			}else{
				$mainImage = $productList['main_image'];
			}
	
	//product Description
	$proDes = $coreModel->selectData("*", "product_description", array("product_id"=> $_GET['id'] ) );
	foreach($proDes as $proDesList);
	
	//product Sub Image
	$proImgList = $coreModel->selectData("*", "product_image", array("product_id"=> $_GET['id'] ) );
	 
	$proSubImgId1["product_image_id"] = $proImgList[0]['product_image_id'];
	$proSubImgId2["product_image_id"] = $proImgList[1]['product_image_id'];
	$proSubImgId3["product_image_id"] = $proImgList[2]['product_image_id'];
	if ($proImgList[0]['image'] == '') {
          $proSubImg1 = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
    }else{
          $proSubImg1 = $proImgList[0]['image'];
    }
	if ($proImgList[1]['image'] == '') {
          $proSubImg2 = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
    }else{
          $proSubImg2 = $proImgList[1]['image'];
    }
	if ($proImgList[2]['image'] == '') {
          $proSubImg3 = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
    }else{
          $proSubImg3 = $proImgList[2]['image'];
    }
	
	//Related Product
	
	$Pid = $_GET['id'];
	
	$getRelated = $myModel->customQuery("
		SELECT product_description.name, product_description.product_id
		FROM product_description
		LEFT JOIN product_related
			ON product_description.product_id = product_related.`related_id`
		WHERE product_related.product_id = $Pid");
	
	
	//Product TO Category
	$saveProductTOCategory = array();
	$getCategoryFromDB = $coreModel->selectData("*", "product_to_category", array("product_id"=> $_GET['id'] ) );
	foreach($getCategoryFromDB as $categoryValue){
		$saveProductTOCategory[] = $categoryValue['category_id'];		
	}
	
	//Product Color
	$saveProColor = array();
	$getProColor = $coreModel->selectData("*", "product_color", array("product_id"=> $_GET['id'] ) );
	foreach($getProColor as $colorValue){
		$saveProColor[] = $colorValue['color_id'];		
	}
	//Product Size
	$saveProSize = array();
	$getProSize = $coreModel->selectData("*", "product_size", array("product_id"=> $_GET['id'] ) );
	foreach($getProSize as $sizeValue){
		$saveProSize[] = $sizeValue['size_id'];		
	}
	//Product Discount
	$proDis = $coreModel->selectData("*", "product_discount", array("product_id"=> $_GET['id'] ) );
	
}

?>

		<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Products
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="product-list.php">Product</a>
                </li>
                <li class="active">Edit Products</li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
			<div class="row">
			
			<!-- success notification  -->
			<div class="col-md-12">
			 <?php if(isset($_SESSION['mgs'])){ echo $_SESSION['mgs']; } ?>
			</div>
			<!-- success notification-->
			
			<form role="form" method="Post" action="productEditProcess.php" enctype="multipart/form-data">
			
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
                            <label>Product Title </label>
                            <input type="hidden" name="product_id" class="form-control" value="<?php echo $productList["product_id"];?>" />
                            <input type="text" name="product_name" class="form-control" value="<?php echo $proDesList["name"];?>" />
                        </div><br/>
						
						<div class="form-group">
							<label>Product Description <span class="star">*</span></label>
                            <textarea name="product_des" class="wysihtml5 form-control"rows="5" ><?php echo $proDesList["description"];?></textarea>
                        </div><br/>
					</div>
				</section>
				<!-- title & description -->
				<!-- Main Image -->
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
								<label class="control-label">Main Image <span class="star">*</span></label><br>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<button value="<?php echo $productList['product_id']; ?>" onClick="return false" title="Delete" class="del_main_img delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                    <img id="main_image" src="<?php echo $mainImage; ?>" alt="" />
                                </div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 110px; line-height: 20px;"></div>
                                <div>
									<span class="btn btn-default btn-file">
                                       <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                       <span class="fileupload-exists"> Change</span>
                                       <input name="main_img" type="file" class="default" />
                                    </span>
                                    <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                </div>
							</div>
						</div> 
						<!-- Sub Image 1 -->							
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub-Image 1 </label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<button value="<?php echo $proSubImgId1['product_image_id']; ?>" onClick="return false" title="Delete" class="del_sub_img1 delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                    <img id="sub_image1" src="<?php echo $proSubImg1; ?>" alt="" />
                                </div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 110px; line-height: 20px;"></div>
                                <div>
									<span class="btn btn-default btn-file">
                                       <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                       <span class="fileupload-exists"> Change</span>
                                       <input name="sub_img1[<?php echo $proSubImgId1['product_image_id']; ?>][]" type="file" class="default" />
                                    </span>
                                    <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                </div>
							</div>
						</div>
						
						<!-- Sub Image 2 -->							
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub-Image 2 </label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<button value="<?php echo $proSubImgId2['product_image_id']; ?>" onClick="return false" title="Delete" class="del_sub_img2 delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                    <img id="sub_image2" src="<?php echo $proSubImg2; ?>" alt="" />
                                </div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 110px; line-height: 20px;"></div>
                                <div>
									<span class="btn btn-default btn-file">
                                       <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                       <span class="fileupload-exists"> Change</span>
                                       <input name="sub_img2[<?php echo $proSubImgId2['product_image_id']; ?>][]" type="file" class="default" />
                                    </span>
                                    <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                </div>
							</div>
						</div>
						<!-- Sub Image 3 -->							
						<div class="col-md-3 form-group">
							<div class=" fileupload fileupload-new" data-provides="fileupload">
								<label class="control-label">Sub-Image 3 </label>
								<div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
									<button value="<?php echo $proSubImgId3['product_image_id']; ?>" onClick="return false" title="Delete" class="del_sub_img3 delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                    <img id="sub_image3" src="<?php echo $proSubImg3; ?>" alt="" />
                                </div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 110px; line-height: 20px;"></div>
                                <div>
									<span class="btn btn-default btn-file">
                                       <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                       <span class="fileupload-exists"> Change</span>
                                       <input name="sub_img3[<?php echo $proSubImgId3['product_image_id']; ?>][]" type="file" class="default" />
                                    </span>
                                    <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                </div>
							</div>
						</div>
					</div>
				</section>
				<!-- Image -->
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
							<div class="col-xs-12 ">
								<div>
								  <label for="birds">Related Products: <span class="star">*</span></label>
								  <input id="related_name_for_search"  class="form-control">
								</div>
								<br />
								<div id="related-product" class="well well-sm" style="height: 120px; overflow: auto;">
									
									
									<?php
									
									foreach($getRelated as $relatedPro){
									?>

										<div id="related-product<?php echo $relatedPro['product_id'];?>"><i title="Remove" class="fa fa-times-circle"></i> <?php echo $relatedPro['name'];?><input type="hidden" name="related_product[]" value="<?php echo $relatedPro['product_id'];?>"></div>
										
										
									<?php									
										
										
									}
									
									?>
									
									
									
									
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
                            <label>Meta Title </label>
                            <input type="text" name="meta_title" class="form-control" value="<?php echo $proDesList["meta_title"];?>" />
                        </div>
					
						<div class="form-group ">
                            <label class="control-label" >Meta Description</label>
                            <textarea name="meta_des" class="form-control" rows="3" ><?php echo $proDesList["meta_description"];?></textarea>
                        </div>
						<div class="form-group ">
                            <label class="control-label" >Meta Keyword</label>
                            <textarea name="meta_keyword" class="form-control" rows="3" ><?php echo $proDesList["meta_keyword"];?></textarea>
                        </div>
						
						<div class="form-group">
							<label>Insert Tags</label>
							<input name="tag" id="tags_1" type="text" class="tags" value="<?php echo $proDesList["tag"];?>" />
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
							<label class="col-xs-4 control-label" >Model </label>
							<div class="col-xs-8">
							<input type="text" name="product_model" class="form-control" value="<?php echo $productList["model"];?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >SKU </label>
							<div class="col-xs-8">
							<input type="text" name="product_sku" class="form-control" value="<?php echo $productList["sku"];?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Quantity</label>
							<div class="col-xs-8">
							<input type="text" name="product_quantity" class="form-control" value="<?php echo $productList["quantity"];?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Stock <span class="star">*</span></label>
							<div class="col-xs-8">
								<select name="stock_id" class="form-control">
									
									<?php 
									$stock_id = $productList['stock_status_id'];
									$stock = $coreModel->SelectData("*", "stock_status");
									foreach($stock as $stock_status) { ?>
										<option value="<?php echo $stock_status['stock_status_id'];?>" <?php if($stock_id==$stock_status['stock_status_id']){ echo "selected='selected'"; } ?> > <?php echo $stock_status['stock_name'];?>
										</option>
									<?php  }  ?>
									
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Price </label>
							<div class="col-xs-8">
							<input type="text" name="product_price" class="form-control" value="<?php echo $productList["price"];?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Brand <span class="star">*</span></label>
							<div class="col-xs-8">
								<select id="brand" name="brnad_id" class="form-control">
										<option value=""> Select Brand</option>
									<?php 
									$brand_id = $productList['manufacturer_id'];
									$brand = $coreModel->SelectData("*", "manufacturer");
									foreach($brand as $brandList) { ?>
										<option value="<?php echo $brandList['manufacturer_id'];?>" <?php if($brand_id==$brandList['manufacturer_id']){ echo "selected='selected'"; } ?> > <?php echo $brandList['brand_name'];?>
										</option>
									<?php  }  ?>
								</select>
							</div>
						</div>
					
					</div>
				</section>
				<!-- Info -->
				
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
								<select name="category_id[]" multiple="multiple"  class="selectCat">
									
						<?php
						$queryCat = categoryParentChildTree();
						foreach($queryCat as $catList){	?>
							<option value="<?php echo $catList['category_id'];?>" <?php if(in_array($catList['category_id'], $saveProductTOCategory)){ echo "selected='selected'"; } ?>>
							<?php echo $catList['cat_name'];?>
							</option>
						<?php } ?>
								
								</select>
							</div>
						</div>
						
				<!---------------  Create New Category   ------------------->
						
						<div class="panel-group " id="accordion">
							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										<h6 class="panel-title">Click to Create New Category</h6>
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
												$queryCat = categoryParentChildTree();
												foreach($queryCat as $newcatList){	?>
													<option value="<?php echo $newcatList['category_id'];?>" >
													<?php echo $newcatList['cat_name'];?>
													</option>
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
						<!---------------  end Create New Category  ------------------->
		
					</div>
				</section>
				<!-- CATEGORY -->
				
				<section class="panel">
					<header class="panel-heading">
						Color 
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-up"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div style="display: none;" class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 color">
								<select multiple="multiple" name="color_id[]" class="selectColor">
									
									<?php
									$queryColor = $coreModel->SelectData("*", "color");
									foreach($queryColor as $colorList){
									?>
									<option value="<?php echo $colorList['color_id'];?>" <?php if(in_array($colorList['color_id'], $saveProColor)){ echo "selected='selected'"; } ?>>
										<?php echo $colorList['color_name'];?>
									</option>
									<?php  }  ?>
									
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
							<a href="javascript:;" class="fa fa-chevron-up"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div style="display: none;" class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 size">
								<select multiple="multiple" name="size_id[]" class="selectSize">
									<?php
									$querySize = $coreModel->SelectData("*", "size");
									foreach($querySize as $sizeList){
									?>
									
									<option value="<?php echo $sizeList['size_id'];?>" <?php if(in_array($sizeList['size_id'], $saveProSize)){ echo "selected='selected'"; } ?>>
										<?php echo $sizeList['size_name'];?>
									</option>
									<?php  } ?>
									
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
								<input type="text" name="weight" class="form-control" value="<?php echo $productList["weight"];?>"/>
							</div>
							<div class="col-xs-4">
								<select id="weight_id" name="weight_id" class="form-control">
									
									<?php 
									$weightId = $productList['weight_class_id'];
									$queryWeight = $coreModel->SelectData("*", "weight_class");
									foreach($queryWeight as $weightList){
									?>
									<option value="<?php echo $weightList['weight_class_id'];?>" <?php if($weightId==$weightList['weight_class_id']){ echo "selected='selected'"; } ?>>
										<?php echo $weightList['weight_class_name'];?>
									</option>
									
									<?php  } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" >Dimensions </label>
							<div class="col-xs-8">
								<input type="text" name="length" class=" form-control" value="<?php echo $productList["length"];?>"/>
							</div>
							<div class="col-xs-offset-4 col-xs-8">
								<input type="text" name="width" class=" form-control" value="<?php echo $productList["width"];?>"/>
							</div>
							<div class="col-xs-offset-4 col-xs-8">
								<input type="text" name="height" class=" form-control" value="<?php echo $productList["height"];?>"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" >Length Class </label>
							<div class="col-xs-8">
								<select id="length_id" name="length_id" class="form-control">
									
									<?php 
									$lengthId = $productList['length_class_id'];
									$queryLength = $coreModel->SelectData("*", "length_class");
									foreach($queryLength as $lengList){
									?>
									<option value="<?php echo $lengList['length_class_id'];?>" <?php if($lengthId==$lengList['length_class_id']){ echo "selected='selected'"; } ?> >
										<?php echo $lengList['length_class_name'];?>
									</option>
									<?php  }  ?>
									
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
					
					<?php foreach($proDis as $key => $proDisList) {  ?>
						<span class="label label-warning">Discount <?php echo $key+1;?></span>
						
						&nbsp; Delete discount ? <input type="checkbox" value="<?php echo $proDisList["product_discount_id"];?>" name="deleteDisc" />
						<div class="form-group">
							<label class="col-xs-4 control-label" for="price">Dis. Price</label>
							<div class="col-xs-8">
								<input class="form-control" name="dis_price" value="<?php echo $proDisList["price"];?>" type="number"/>
							</div>
						</div>
					
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Dis. Unit</label>
                            <div class="col-xs-8">
                                <input class="form-control" name="dis_quantity" value="<?php echo $proDisList["quantity"];?>" type="number"/>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Points</label>
                            <div class="col-xs-8">
                                <input class="form-control" name="points" value="<?php echo $productList["points"];?>" type="number"/>
                            </div>
                        </div>
					
						<div class="form-group">
                            <label class="col-xs-4 control-label" for="price">Dis. Priority</label>
                            <div class="col-xs-8">
                                <select name="priority" class="form-control">
								
									<option value="0" <?php if($proDisList["priority"]=="0"){ echo "selected='selected'"; } ?> >Off</option>
									<option value="1" <?php if($proDisList["priority"]=="1"){ echo "selected='selected'"; } ?> >On</option>
								</select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-xs-4 control-label" >Dis. Start </label>
                            <div class="col-xs-8">
                              <input class="form-control" name="date_start" value="<?php echo $proDisList["date_start"];?>" type="date"/>
                            </div>
                        </div>
					
						<div class="form-group ">
                            <label class="col-xs-4 control-label" >Dis. End </label>
                            <div class="col-xs-8">
                              <input class="form-control" name="date_end" value="<?php echo $proDisList["date_end"];?>" type="date"/>
                            </div>
                        </div>
						
					<?php  }  ?>
					
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
								<input type="text" name="sort_order" class=" form-control" value="<?php echo $productList['sort_order'];?>" />
							</div>
                        </div>
						<div class="form-group">
                            <label class="col-xs-6 control-label" for="productType">Product Type :</label>
							<div class="col-xs-6">
								<select name="type" class="form-control">
									<option value="General" <?php if($productList['type']=="General"){ echo "selected='selected'"; } ?> >General</option>
									<option value="Featured" <?php if($productList['type']=="Featured"){ echo "selected='selected'"; } ?> >Featured</option>
								</select>
							</div>
                        </div>
						<div class="form-group">
                            <label class="col-xs-6 control-label" for="productsku">Product Status :</label>
							<div class="col-xs-6">
								<select name="status" class="form-control">
									<option value="Active" <?php if($productList['status']=="Active"){ echo "selected='selected'"; } ?> >Active</option>
									<option value="Inactive" <?php if($productList['status']=="Inactive"){ echo "selected='selected'"; } ?> >Inactive</option>
								</select>
							</div>
                        </div>
						<button type="submit" name="update_product" class="btn btn-success">Update Product</button>
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
// var i = 0;
// function appendDiscount() {
	// i++;
    // var discount = $("#discount").html()+'<input type="button" onClick="remove()" class="btn btn-success" value="Delete" />';
	
    // $("#append_discount").append(discount);
// }

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
                document.getElementById("addMsg").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax_loader.php?cat_name=" + cat_name+"&parent_id=" + cat_parent_id , true);
        xmlhttp.send();
    }
}
</script>
<script>
// delete main Image
$(document).ready(function(){
    $(".del_main_img").click(function(){
        var product_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_main_image:product_id}
        }).done(function(){
           $("#main_image").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
// delete sub Image-1
$(document).ready(function(){
    $(".del_sub_img1").click(function(){
        var product_image_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_sub_image1:product_image_id}
        }).done(function(){
           $("#sub_image1").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
// delete sub Image-2
$(document).ready(function(){
    $(".del_sub_img2").click(function(){
        var product_image_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_sub_image2:product_image_id}
        }).done(function(){
           $("#sub_image2").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
// delete sub Image-3
$(document).ready(function(){
    $(".del_sub_img3").click(function(){
        var product_image_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_sub_image3:product_image_id}
        }).done(function(){
           $("#sub_image3").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
</script>

<script>
  $( function() {
    
    $( "#related_name_for_search" ).autocomplete({
		source: "search-related-edit.php",
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

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  
unset($_SESSION['mgs']);
?>

