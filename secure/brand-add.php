<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Product Brand
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Product Brands</a>
                </li>
                <li class="active"> Add Brand </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
        if(isset($_POST['add_brand']))
    		{
    			$tableName = "manufacturer";
                $columnValue["brand_name"] = $_POST['brand_name'];
                $columnValue["category_id"] = $_POST['cat_id'];


                $name = $_POST['brand_name'];
                $photoName = str_replace(' ', '-', $name);
                $myExtension = array("jpg", "png", "jpeg", "gif", "ico");

                $logoFilenameArray = explode( ".", $_FILES['brand_logo']['name'] );
                $logoFileExtension = end($logoFilenameArray); 
                $logoFolderName = "uploads/categories/brands/";
                if (($_FILES['brand_logo']['error'] == 0) &&
                    in_array($logoFileExtension, $myExtension) &&
                    ($_FILES['brand_logo']['size'] < 999999)) 
                {
                    $logoTemporarUploadedFile = $_FILES['brand_logo']['tmp_name'];
                    $logoFilesNewName = $photoName . '.'. $logoFileExtension;
                    $logoFinalDestination = $logoFolderName . $logoFilesNewName;
                    $columnValue["logo"] = $logoFinalDestination;
                    move_uploaded_file($logoTemporarUploadedFile, $logoFinalDestination);
                }
    			
    			$queryResult = $coreModel->insertData($tableName, $columnValue);
    			
    			if($queryResult['no_of_row_inserted'] > 0)
    			{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully added the brand named: <strong>'.$_POST['brand_name'].'</strong>
    				</div>
    				';
    			}
    		}
		?> 
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Select a Category and put Brand Name
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="sub_cat">Brand Name <span class="star">*</span></label>
                                <input required name="brand_name" type="text" class="form-control" id="sub_cat" placeholder="Put your brand name">
                            </div>
							<div class="form-group">
								<label for="cat">Category <span class="star">*</span></label>
								<select id="cat" required name="cat_id" class="form-control m-bot15">
									<option value="">Select a category</option>
									<?php 
									$tableName = "category";
									$columnName["1"] = "category_id";
									$columnName["2"] = "cat_name";
									$whereValue["parent_id"] = 0;
									$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
									foreach ($queryResult as $catList) {
										$catId = $catList['category_id'];
										$catName = $catList['cat_name'];
										echo "<option value='$catId'>$catName</option>";
										}
									?>
								</select>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                    <label class="control-label">Logo <span class="star">*</span></label><br>
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
                                    <div>
                                           <span class="btn btn-default btn-file">
                                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                           <span class="fileupload-exists"> Change</span>
                                           <input name="brand_logo" type="file" class="default" />
                                           </span>
                                        <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                    </div>
                                </div>
                            </div><div class="clearfix"></div>
                            <br>
                            <button type="submit" name="add_brand" class="btn btn-success"><i class="fa fa-plus"></i> Add Brand</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>