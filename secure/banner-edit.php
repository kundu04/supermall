<?php include("fw-config.php") ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Banner
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Banner</a>
                </li>
                <li class="active"> Edit Banner </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 

        $tableName = "banner";
        $columnName = "*";
        $whereValue["banner_id"] = $_GET['bid'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);	
        foreach ($queryResult AS $ban);

        if ($ban['image'] == '') {
            $image = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
        }else{
            $image = $ban['image'];
        }
		
        if(isset($_POST['save_banner']))
		{
            $columnValue["name"] = $_POST['name'];
            $columnValue["link"] = $_POST['link'];
			$columnValue["status"] = $_POST['status'];
			$columnValue["position"] = $_POST['position'];
			$columnValue["sort_order"] = $_POST['sort_order'];
            
            $name = $_POST['name'];
            $photoName = str_replace(' ', '-', $name);
            $myExtension = array("jpg", "png", "jpeg", "gif", "ico");

            $filenameArray = explode( ".", $_FILES['banner_image']['name'] );
            $fileExtension = end($filenameArray); 
            $folderName = "uploads/banner/";
            if (($_FILES['banner_image']['error'] == 0) &&
                in_array($fileExtension, $myExtension) &&
                ($_FILES['banner_image']['size'] < 999999)) 
            {
                $temporarUploadedFile = $_FILES['banner_image']['tmp_name'];
                $filesNewName = $photoName . '.'. $fileExtension;
                $finalDestination = $folderName . $filesNewName;
                $columnValue["image"] = $finalDestination;
                move_uploaded_file($temporarUploadedFile, $finalDestination);	
            }
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			
			if($queryResult > 0)
			{
				echo '
				<div class="alert alert-success fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
						<i class="fa fa-times"></i></button>
					You have successfully updated the banner named: <strong>'.$_POST['name'].'</strong>.
				</div>
				';
                header("Refresh: 2;url=banner-list");
                ob_end_flush();
			}
		}
        if (isset($_POST['cancel'])) {
            header("Location: banner-list");
        }
		?>
         
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Edit Banner details
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="banner">Banner Name <span class="star">*</span></label>
                                <input required name="name" type="text" class="form-control" id="banner" value="<?php echo $ban['name']; ?>">
                            </div>
							<div class="form-group">
                                <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                    <label class="control-label">Banner Image <span class="star">*</span></label><br>
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
										<button value="<?php echo $ban['banner_id']; ?>" onClick="return false" title="Delete" class="del_banner_img delete-cat-pic btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                        <img id="banner_image" src="<?php echo $image; ?>" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
                                    <div>
                                         <span class="btn btn-default btn-file">
                                         <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                         <span class="fileupload-exists"> Change</span>
                                         <input name="banner_image" type="file" class="default" />
                                         </span>
                                        <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                    </div>
                                </div>
                            </div>
							<div class="clearfix"></div><br>
							<div class="form-group">
                                <label for="link">Image Link <span class="star"></span></label>
                                <input name="link" type="text" class="form-control" id="link" value="<?php echo $ban['link']; ?>">
                            </div>
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" name="status" class="form-control m-bot15">
									<option value="Active" <?php if($ban['status']=="Active"){ echo "selected='selected'"; } ?> >Active</option>
									<option value="Inactive" <?php if($ban['status']=="Inactive"){ echo "selected='selected'"; } ?> >Inactive</option>
                                </select>
                            </div>
							<div class="form-group">
                                <label for="position">Position <span class="star"></span></label>
                                <input name="position" type="text" class="form-control" id="position" value="<?php echo $ban['position']; ?>">
                            </div>
							<div class="form-group">
                                <label for="sort_order">Sort Order <span class="star"></span></label>
                                <input name="sort_order" type="text" class="form-control" id="sort_order" value="<?php echo $ban['sort_order']; ?>">
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="save_banner" class="btn btn-success"><i class="fa fa-plus"></i> Update </button>
							<button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<script>
// delete slider Image
$(document).ready(function(){
    $(".del_banner_img").click(function(){
        var banner_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{del_banner_image:banner_id}
        }).done(function(){
           $("#banner_image").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
        });
    });
});
</script>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>