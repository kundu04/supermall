<?php include("fw-config.php") ?>
<?php $coreView->call("header"); ?>
<?php $coreView->call("sidebar"); ?>
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

?>
		<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Category
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="category-list.php">Category</a>
                </li>
                <li class="active">Add Category</li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
			<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<!--success notification-->
			<?php
			
			if (isset($_POST['add_category']))
			{
				$tableName = "category";
				$columnValue["cat_name"] = $_POST['category_name'];
				$columnValue["parent_id"] = $_POST['parent_id'];

	            if (isset($_POST['top'])) {
	                $columnValue["top"] = 1;
	            }else{
	                $columnValue["top"] = 0;
	            }

	            $name = $_POST['category_name'];
	            $photoName = str_replace(' ', '-', $name);
				$myExtension = array("jpg", "png", "jpeg", "gif", "ico");

	            $logoFilenameArray = explode( ".", $_FILES['cat_logo']['name'] );
	            $logoFileExtension = end($logoFilenameArray); 
	            $logoFolderName = "uploads/categories/logo/";
	            if (($_FILES['cat_logo']['error'] == 0) &&
	                in_array($logoFileExtension, $myExtension) &&
	                ($_FILES['cat_logo']['size'] < 999999)) 
	            {
	                $logoTemporarUploadedFile = $_FILES['cat_logo']['tmp_name'];
	                $logoFilesNewName = $photoName . '.'. $logoFileExtension;
	                $logoFinalDestination = $logoFolderName . $logoFilesNewName;
	                $columnValue["logo"] = $logoFinalDestination;
	                move_uploaded_file($logoTemporarUploadedFile, $logoFinalDestination);
	            }

	            $filenameArray = explode( ".", $_FILES['cat_banner']['name'] );
	            $fileExtension = end($filenameArray); 
	            $folderName = "uploads/categories/";
	            if (($_FILES['cat_banner']['error'] == 0) &&
	                in_array($fileExtension, $myExtension) &&
	                ($_FILES['cat_banner']['size'] < 999999)) 
	            {
	                $temporarUploadedFile = $_FILES['cat_banner']['tmp_name'];
	                $filesNewName = $photoName . '.'. $fileExtension;
	                $finalDestination = $folderName . $filesNewName;
	                $columnValue["banner"] = $finalDestination;
	                move_uploaded_file($temporarUploadedFile, $finalDestination);
	            }
				
				$queryResult = $coreModel->insertData($tableName, $columnValue);
				
				if (!$queryResult)
					echo '
						<div class="alert alert-danger alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i></button>
							<p>You have not inputed category name. Please input category name.</p>
						</div> 
					';
				else
				{
					echo '
						<div class="alert alert-success alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i></button>
							<p>You have successfully added the category named <strong>'.$_POST['category_name'].' </strong>.</p>
						</div> 
					';
				}
			}
			?>
			<!--success notification-->
		
            
                <section class="panel">
                    <header class="panel-heading">
                        Please put your category name
                    </header>
                    <div class="panel-body">
                        <form role="form" method="Post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="cat-name">Category Name <span class="star">*</span></label>
                                <input required type="text" name="category_name" class="form-control" id="cat-name" placeholder="Enter your category name">
                            </div>
							
							<div class="form-group">
                                <label for="cat-name">Parent</label>
                                <select name="parent_id" class="form-control">
								<option value="0"> No-Parent</option>

		                        <?php 
                               	$categoryList = categoryParentChildTree(); 
		                        foreach($categoryList as $value){ ?>
								 <option value="<?php echo $value['category_id']; ?>"> <?php echo $value['cat_name']; ?></option> 
								<?php } ?>					  
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
                                           <input name="cat_logo" type="file" class="default" />
                                           </span>
                                        <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                    </div>
                                </div>
                                <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                    <label class="control-label">Banner <span class="star">*</span></label><br>
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
                                    <div>
                                           <span class="btn btn-default btn-file">
                                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                           <span class="fileupload-exists"> Change</span>
                                           <input name="cat_banner" type="file" class="default" />
                                           </span>
                                        <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                    </div>
                                </div>
                            </div><div class="clearfix"></div><br>
							
							<div class="form-group">
                                <label for="sort-order">Sort Order</label>
                                <input type="text" name="sort_order" class="form-control" id="sort-order" placeholder="Enter Sort-order value">
                            </div>
							
							<div style="margin-top: 20px;" class="checkbox">
                                <label>
                                    <input type="checkbox"  name="top" > Add to top Menu
                                </label>
                            </div><br>
							
                            <button type="submit" name="add_category" class="btn btn-success"><i class="fa fa-plus"></i> Add Category</button>
                        </form>

                    </div>
                </section>
            </div>
		</div>
        </div>
        <!--body wrapper end-->

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>


