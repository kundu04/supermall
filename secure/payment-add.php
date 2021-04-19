<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Payment Method
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Payment Method</a>
                </li>
                <li class="active"> Add Payment Method </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
        if(isset($_POST['add_payment']))
    		{
    			$tableName = "payment_method";
                $columnValue["title"] = $_POST['title'];
                $columnValue["code"] = $_POST['code'];
                $columnValue["status"] = $_POST['status'];

                $queryResult = $coreModel->insertData($tableName, $columnValue);
    			
    			if($queryResult['no_of_row_inserted'] > 0)
    			{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully added Payment Method: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
    			}
    		}
		?> 
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Payment Method Details
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="payment_title">Payment Method Title <span class="star">*</span></label>
                                <input required name="title" type="text" class="form-control" id="payment_title" placeholder="Put Payment method title" />
                            </div>
							
							<div class="form-group">
                                <label for="code">Code <span class="star">*</span></label>
                                <input name="code" type="text" class="form-control" id="code" placeholder="code" required />
                            </div>
														
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0">Disable</option>
									<option value="1">Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="add_payment" class="btn btn-success"><i class="fa fa-plus"></i> Add Payment Method</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>