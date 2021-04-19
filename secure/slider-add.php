<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Slider Image
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Slider</a>
                </li>
                <li class="active"> Add Slider </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<div class="row">
            <div class="col-md-6 col-md-offset-3">
			<?php 
			if(isset($_POST['add_slider']))
    		{
    			$tableName = "slider";
                $columnValue["name"] = $_POST['name'];
                $columnValue["title"] = $_POST['title'];
                $columnValue["sub_title"] = $_POST['sub_title'];
                $columnValue["status"] = $_POST['status'];
                $columnValue["link"] = $_POST['link'];
                $columnValue["sort_order"] = $_POST['sort_order'];


                $name = $_POST['name'];
                $photoName = str_replace(' ', '-', $name);
                $myExtension = array("jpg", "png", "jpeg", "gif", "ico");

                $logoFilenameArray = explode( ".", $_FILES['slider_image']['name'] );
                $logoFileExtension = end($logoFilenameArray); 
                $logoFolderName = "uploads/slider/";
                if (($_FILES['slider_image']['error'] == 0) &&
                    in_array($logoFileExtension, $myExtension) &&
                    ($_FILES['slider_image']['size'] < 999999)) 
                {
                    $logoTemporarUploadedFile = $_FILES['slider_image']['tmp_name'];
                    $logoFilesNewName = $photoName . '.'. $logoFileExtension;
                    $logoFinalDestination = $logoFolderName . $logoFilesNewName;
                    $columnValue["image"] = $logoFinalDestination;
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
    					You have successfully added slider named: <strong>'.$_POST['name'].'</strong>
    				</div>
    				';
    			}
    		}
			?>
                <section class="panel">
                    <header class="panel-heading">
                        Slider Details
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="slider_name">Slider Name <span class="star">*</span></label>
                                <input required name="name" type="text" class="form-control" id="slider_name" placeholder="Put slider name">
                            </div>
							<div class="form-group">
                                <label for="slider_title">Slider Title <span class="star"></span></label>
                                <input name="title" type="text" class="form-control" id="slider_title" placeholder="Put slider title">
                            </div>
							<div class="form-group">
                                <label for="sub_title">Slider Sub-Title <span class="star"></span></label>
                                <input name="sub_title" type="text" class="form-control" id="sub_title" placeholder="Put slider sub-title">
                            </div>
							
                            <div class="form-group">
                                <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                    <label class="control-label">Slider Image <span class="star">*</span></label><br>
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 110px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 110px; line-height: 20px;"></div>
                                    <div>
                                           <span class="btn btn-default btn-file">
                                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                           <span class="fileupload-exists"> Change</span>
                                           <input required name="slider_image" type="file" class="default" />
                                           </span>
                                        <a title="Remove" href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> </a>
                                    </div>
                                </div>
                            </div>
							<div class="clearfix"></div><br>
							<div class="form-group">
                                <label for="link">Image Link <span class="star"></span></label>
                                <input name="link" type="text" class="form-control" id="link" placeholder="Put image link">
                            </div>
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="Active">Active</option>
									<option value="Inactive">Inactive</option>
                                </select>
                            </div>
							<div class="form-group">
                                <label for="sort_order">Sort Order <span class="star"></span></label>
                                <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Sort Order">
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="add_slider" class="btn btn-success"><i class="fa fa-plus"></i> Add Slider</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>