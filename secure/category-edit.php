<?php include("fw-config.php"); ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Category
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Category</a>
                </li>
                <li class="active"> Edit Category </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
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

        $tableName = "category";
        $columnName = "*";
        $whereValue["category_id"] = $_GET['cid'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
        foreach ($queryResult AS $cat);
		
		if ($cat['top'] == 1) {
            $checked = 'checked';
        }

        if ($cat['logo'] == '') {
            $logo = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
        }else{
            $logo = $cat['logo'];
        }

        if ($cat['banner'] == '') {
            $photo = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
        }else{
            $photo = $cat['banner'];
        }

        if(isset($_POST['save_category']))
		{
            $columnValue["cat_name"] = $_POST['category_name'];
            $columnValue["parent_id"] = $_POST['parent_id'];
			$columnValue["sort_order"] = $_POST['sort_order'];

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
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			
			if($queryResult > 0)
			{
				echo '
				<div class="alert alert-success fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
						<i class="fa fa-times"></i></button>
					You have successfully saved the category named: <strong>'.$_POST['category_name'].'</strong>.
				</div>
				';
                header("Refresh: 2;url=category-list");
                ob_end_flush();
			}
		}
        if (isset($_POST['cancel'])) {
            header("Location: category-list");
        }
		?>
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Please put a valid Category Name
                    </header>
                    <div class="panel-body">
						<form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name <span class="star">*</span></label>
                                <input required name="category_name"	type="text" class="form-control" value="<?php echo $cat['cat_name']; ?>">
                            </div>
							<div class="form-group">
                                <label for="cat-name">Parent</label>
                                <select name="parent_id" class="form-control">
								<option value="0"> No-Parent</option>

		                        <?php 
                               	$categoryList = categoryParentChildTree(); 
		                        foreach($categoryList as $value){ ?>
								
								<option value="<?php echo $value['category_id']; ?>" <?php if($value['category_id']==$cat['parent_id']){ echo "selected='selected'"; } ?> > <?php echo $value['cat_name']; ?></option> 
								<?php } ?>					  
								</select>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                    <label class="control-label">Logo <span class="star">*</span></label><br>
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;"><button value="<?php echo $cat['category_id']; ?>" onClick="return false" title="Delete" class="del_cat_logo delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                        <img id="logo" src="<?php echo $logo; ?>" alt="" />
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
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;"><button value="<?php echo $cat['category_id']; ?>" onClick="return false" title="Delete" class="del_cat_banner delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                        <img id="img" src="<?php echo $photo; ?>" alt="" />
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
                            </div>
                           <div class="clearfix"></div><br>
						   <div class="form-group">
                                <label for="Sort_order">Sort Order <span class="star">*</span></label>
                                <input name="Sort_order"	type="text" class="form-control" value="<?php echo $cat['sort_order']; ?>" id="sort_order">
                            </div>
                            <div style="margin-top: 20px;" class="checkbox">
                                <label>
                                    <input <?php echo $checked; ?> type="checkbox"  name="top" > Add to top Menu
                                </label>
                            </div><br>
                            <button type="submit" name="save_category" class="btn btn-primary">Update </button>
                            <button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>
<script>
// delete category logo
$(document).ready(function(){
    $(".del_cat_logo").click(function(){
        var cat_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_cat_logo:cat_id}
        }).done(function(){
           $("#logo").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});

// delete category banner
$(document).ready(function(){
    $(".del_cat_banner").click(function(){
        var cat_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_cat_banner:cat_id}
        }).done(function(){
           $("#img").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
</script>
		
<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>