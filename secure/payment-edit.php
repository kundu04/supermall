<?php include("fw-config.php") ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Payment Method
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Payment Method</a>
                </li>
                <li class="active"> Edit Payment Method </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
		
		$tableName = "payment_method";
        $columnName = "*";
        $whereValue["payment_id"] = $_GET['pid'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);	
        foreach ($queryResult AS $payment);
		
		if(isset($_POST['save_payment'])){
			
				$columnValue["title"] = $_POST['title'];
				
				$columnValue["code"] = $_POST['code'];
				
				$columnValue["status"] = $_POST['status'];
			
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			
			if($queryResult > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully Updated Payment Method: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
					header("Refresh: 2;url=payment-list");
					ob_end_flush();
    			}
    	}
		
		if (isset($_POST['cancel'])) {
            header("Location: payment-list");
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
                                <input required name="title" type="text" class="form-control" id="payment_title" value="<?php echo $payment['title']; ?>" />
                            </div>
							
							
							<div class="form-group">
                                <label for="code">Code <span class="star">*</span></label>
                                <input name="code" type="text" class="form-control" id="code" value="<?php echo $payment['code']; ?>" required />
                            </div>
							
							
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0" <?php if($payment['status']=="0"){ echo "selected='selected'"; } ?>>Disable</option>
									<option value="1" <?php if($payment['status']=="1"){ echo "selected='selected'"; } ?>>Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="save_payment" class="btn btn-success"><i class="fa fa-plus"></i> Update</button>
							<button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>