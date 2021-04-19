
<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<?php 

if(isset($_GET['id']) ) 
{
	$product = $coreModel->selectData("*", "product", array("product_id"=> $_GET['id'] ) );
	foreach($product as $productList);
	
	$proDes = $coreModel->selectData("*", "product_description", array("product_id"=> $_GET['id'] ) );
	foreach($proDes as $proDesList);
	
	$proImg = $coreModel->selectData("*", "product_image", array("product_id"=> $_GET['id'] ) );
	
	$brand_id = $productList['manufacturer_id'];
	$proManu = $coreModel->selectData("*", "manufacturer", array("manufacturer_id"=> $brand_id ) );
	foreach($proManu as $proManuList);
	
	$weightId = $productList['weight_class_id'];
	$weight = $coreModel->selectData("*", "weight_class", array("weight_class_id"=> $weightId ) );
	foreach($weight as $weightList);
	
	$lengthId = $productList['length_class_id'];
	$length = $coreModel->selectData("*", "length_class", array("length_class_id"=> $lengthId ) );
	foreach($length as $lengthList);
	
	$proDis = $coreModel->selectData("*", "product_discount", array("product_id"=> $_GET['id'] ) );
	
	$cat_proToCat = $myModel->get_cat_proToCat();
	
	$proColor = $myModel->get_proColor();
	
	$proSize = $myModel->get_proSize();
	
	
	
}



?>

		<!-- page heading start-->
        <div class="page-heading">
            <h3>
                View Products
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="product-list.php">Product</a>
                </li>
                <li class="active">View Products</li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
			<div class="row">
			
			<div class="col-md-8">
				<section class="panel">
					<header class="panel-heading">
						Product Details
					</header>
					<div class="panel-body">
						<div class="form-group">
                            <label>Product Title </label>
							
                            <h4><?php echo $proDesList["name"];?></h4>
							<br/>
							
							<div class="col-md-offset-3 col-md-6">
								<img src="../<?php echo $productList["main_image"];?>" width="100%" alt="" />
							</div>
							<div class="clearfix"></div><br/>
							
							<?php foreach($proImg as $proImgList) {  ?>
							
							<div class="col-md-3">
								<img src="../<?php echo $proImgList["image"];?>" width="100%" alt="" />
							</div> 
							
							<?php  }  ?>
                        </div>
						<div class="clearfix"></div><br/>
						
						<div class="form-group">
							<label>Product Description </label>
                            <textarea name="product_des" class=" form-control" rows="8"><?php echo $proDesList["description"];?></textarea>
                        </div><br/>
					</div>
				</section>
				<!-- title & description -->
				
				
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
							<label class="col-xs-4 control-label" >Model</label>
							<div class="col-xs-6">
							<input disabled type="text" class="form-control" value="<?php echo $productList["model"];?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >SKU</label>
							<div class="col-xs-6">
							<input disabled type="text" class="form-control" value="<?php echo $productList["sku"];?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Quantity</label>
							<div class="col-xs-6">
							<input disabled type="text" class="form-control" value="<?php echo $productList["quantity"];?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Price</label>
							<div class="col-xs-6">
							<input disabled type="text" class="form-control" value="<?php echo $productList["price"];?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Brand</label>
							<div class="col-xs-6">
							<input disabled type="text" class="form-control" value="<?php echo $proManuList["brand_name"];?>" />
							</div>
						</div>
						
					
					</div>
				</section>
				<!-- Info -->
				
				<section class="panel">
                    <header class="panel-heading">
                        SEO
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
					<div class="panel-body form-horizontal">
						<div class="form-group">
                            <label class="col-sm-2 control-label">Meta Title</label>
							<div class="col-sm-10">
								<input disabled type="text" class="form-control" value="<?php echo $proDesList["meta_title"];?>" />
							</div>
                        </div>
					
						<div class="form-group ">
                            <label class="col-sm-2 control-label" >Meta Description</label>
							<div class="col-sm-10">
								<textarea disabled class="form-control" rows="3" ><?php echo $proDesList["meta_description"];?></textarea>
							</div>
                        </div>
						
						<div class="form-group ">
                            <label class="col-sm-2 control-label" >Meta Keyword</label>
							<div class="col-sm-10">
								<textarea disabled class="form-control" rows="2" ><?php echo $proDesList["meta_keyword"];?></textarea>
							</div>
                        </div>
						
						<div class="form-group ">
                            <label class="col-sm-2 control-label" >Meta Tags</label>
							<div class="col-sm-10">
								<textarea disabled class="form-control" rows="2" ><?php echo $proDesList["tag"];?></textarea>
							</div>
                        </div>
						
					</div>
				</section>
				<!-- SEO -->
				
			</div>
			<!--col-8-->
				
			<div class="col-md-4">
				
				<section class="panel">
					<header class="panel-heading">
						Edit Product
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						 </span>
					</header>
					<div class="panel-body form-horizontal">
						<h4>Total Viewed : <?php echo $productList['viewed'];?></h4>
						<br />
						<?php 
						if($productList['status'] == "Inactive"){
							$status = "danger";
						} else {
							$status = "success";
						}
						
						?>
						<button type="button" name="status" class="btn btn-<?php echo $status;?>"><?php echo $productList['status'];?></button>
						
						<a href="product-edit.php?id=<?php echo $productList['product_id'];?>" class="btn btn-primary pull-right">Edit Product</a>
						
					</div>
				</section>
				<!-- edit -->
				
					
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
							<h5>Selected Category</h5>
							<?php foreach($cat_proToCat as $proCatList) {
								echo '<span style="font-size:1em;" class="label label-success">'.$proCatList['cat_name'].'</span>&nbsp;';
								}
							?>
						</div>
					</div>
				</section>
				<!-- CATEGORY -->
				
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
							<h5>Selected Color</h5>
							<?php foreach($proColor as $proColorList) {
								echo '<span style="font-size:1em;" class="label label-success">'.$proColorList['color_name'].'</span>&nbsp;';
								}
							?>
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
							<h5>Selected Size</h5>
							<?php foreach($proSize as $proSizeList) {
								echo '<span style="font-size:1em;" class="label label-success">'.$proSizeList['size_name'].'</span>&nbsp;';
								}
							?>
						</div>					
					</div>
				</section>
				<!-- Size -->
				
				
				<section class="panel">
                    <header class="panel-heading">
                        Product dimention
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
					<div class="panel-body form-horizontal" >
						
						<div class="form-group">
							<label class="col-xs-4 control-label" >Weight </label>
							<div class="col-xs-4">
								<input disabled type="text" class="form-control" value="<?php echo $productList["weight"];?>"/>
							</div>
							<div class="col-xs-4">
								<input disabled type="text" class="form-control" value="<?php echo $weightList["weight_class_name"];?>"/>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label" >Dimensions (L x W x H) </label>
								<input disabled type="text" class="form-control" value="<?php echo $productList["length"]." X ".$productList["width"]." X ".$productList["height"]." ".$lengthList["length_class_name"] ;?>"/>
							</div>
						</div>
						
					</div>
				</section>
				<!-- Dimensions -->
				
                <section class="panel">
					<header class="panel-heading">
						Price & Discount
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
                    <div class="panel-body form-horizontal">
					
						<!---------------  Discount   ------------------->
						
						<div class="panel-group " id="accordion">
						
						<?php foreach($proDis as $key => $proDisList) {  ?>
						
							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key+1;?>">
										<h6 class="panel-title">Discount <?php echo $key+1;?></h6>
									</a>
								</div>
								<div id="collapse<?php echo $key+1;?>" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-xs-4 control-label" >Dis. Price</label>
											<div class="col-xs-8">
												<input disabled type="text" class="form-control" value="<?php echo $proDisList["price"];?>" />
											</div>
										</div>
									
										<div class="form-group">
											<label class="col-xs-4 control-label" >Dis. Unit</label>
											<div class="col-xs-8">
												<input disabled type="text" class="form-control" value="<?php echo $proDisList["quantity"];?>" />
											</div>
										</div>
									
										<div class="form-group">
											<label class="col-xs-4 control-label" >Points</label>
											<div class="col-xs-8">
												<input disabled type="text" class="form-control" value="<?php echo $productList["points"];?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-4 control-label">Dis. Priority</label>
											<div class="col-xs-8">
												<input disabled type="text" class="form-control" value="<?php echo $proDisList["priority"];?>" />
											</div>
										</div>

										<div class="form-group ">
											<label class="col-xs-4 control-label" >Dis. Start </label>
											<div class="col-xs-8">
											  <input disabled type="text" class="form-control" value="<?php echo $proDisList["date_start"];?>" />
											</div>
										</div>
									
										<div class="form-group ">
											<label class="col-xs-4 control-label" >Dis. End </label>
											<div class="col-xs-8">
											  <input disabled type="text" class="form-control" value="<?php echo $proDisList["date_end"];?>" />
											</div>
										</div>
														
										
									</div>
								</div>
							</div>
							<?php  }  ?>
						</div>
						<!---------------  end Discount  ------------------->
					
						
					
						
                    </div>
                </section>
				<!-- DISCOUNT -->
				
			
				
			</div>
			<!--col-4-->
			
			</div>
			<!--row-->

        </div>
        <!--body wrapper end-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

</script>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>

