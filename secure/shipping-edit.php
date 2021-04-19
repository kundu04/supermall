<?php include("fw-config.php") ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Shipping Method
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Shipping Method</a>
                </li>
                <li class="active"> Edit Shipping Method </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
		
		$tableName = "shipping_method";
        $columnName = "*";
        $whereValue["shipping_id"] = $_GET['sid'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);	
        foreach ($queryResult AS $shipping);
		
		if(isset($_POST['save_shipping'])){
			
				$columnValue["title"] = $_POST['title'];
				
				$columnValue["amount"] = $_POST['amount'];
				
				$columnValue["status"] = $_POST['status'];
			
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			
			if($queryResult > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully Updated Shipping Method: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
					header("Refresh: 2;url=shipping-list");
					ob_end_flush();
    			}
    	}
		
		if (isset($_POST['cancel'])) {
            header("Location: shipping-list");
        }
		?> 
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Shipping Details
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="shipping_title">Shipping Title <span class="star">*</span></label>
                                <input required name="title" type="text" class="form-control" id="shipping_title" value="<?php echo $shipping['title']; ?>" />
                            </div>
							
							
							<div class="form-group">
                                <label for="amount">Amount <span class="star">*</span></label>
                                <input name="amount" type="text" class="form-control" id="amount" value="<?php echo $shipping['amount']; ?>" required />
                            </div>
							
							
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0" <?php if($shipping['status']=="0"){ echo "selected='selected'"; } ?>>Disable</option>
									<option value="1" <?php if($shipping['status']=="1"){ echo "selected='selected'"; } ?>>Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="save_shipping" class="btn btn-success"><i class="fa fa-plus"></i> Update</button>
							<button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>