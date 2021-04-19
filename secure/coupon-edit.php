<?php include("fw-config.php") ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Coupon
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Coupon</a>
                </li>
                <li class="active"> Edit Coupon </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
		
		$tableName = "coupon";
        $columnName = "*";
        $whereValue["coupon_id"] = $_GET['cid'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);	
        foreach ($queryResult AS $coupon);
		
		if(isset($_POST['save_coupon'])){
			
				$columnValue["title"] = $_POST['title'];
				$columnValue["code"] = $_POST['code'];
				$columnValue["type"] = $_POST['type'];
				$columnValue["amount"] = $_POST['amount'];
				$columnValue["uses_total"] = $_POST['uses_total'];
				$columnValue["exp_date"] = $_POST['exp_date'];
				$columnValue["status"] = $_POST['status'];
			
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			
			if($queryResult > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully Updated Coupon: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
					header("Refresh: 2;url=coupon-list");
					ob_end_flush();
    			}
    	}
		
		if (isset($_POST['cancel'])) {
            header("Location: coupon-list");
        }
		?> 
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Coupon Details
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="coupon_title">Coupon Title <span class="star">*</span></label>
                                <input required name="title" type="text" class="form-control" id="coupon_title" value="<?php echo $coupon['title']; ?>" />
                            </div>
							<div class="form-group">
                                <label for="code">Coupon Code <span class="star">*</span></label>
                                <input name="code" type="text" class="form-control" id="code" value="<?php echo $coupon['code']; ?>" required />
                            </div>
							<div class="form-group">
								<label for="type">Coupon Type <span class="star">*</span></label>
								<select id="type" required name="type" class="form-control m-bot15">
									<option value="0" <?php if($coupon['type']=="0"){ echo "selected='selected'"; } ?>>R</option>
									<option value="1" <?php if($coupon['type']=="1"){ echo "selected='selected'"; } ?>>P</option>
									<option value="2" <?php if($coupon['type']=="2"){ echo "selected='selected'"; } ?>>E</option>
									<option value="3" <?php if($coupon['type']=="3"){ echo "selected='selected'"; } ?>>B</option>
									<option value="4" <?php if($coupon['type']=="4"){ echo "selected='selected'"; } ?>>V</option>
									<option value="5" <?php if($coupon['type']=="5"){ echo "selected='selected'"; } ?>>S</option>
                                </select>
                            </div>
							<div class="form-group">
                                <label for="amount">Discount Amount <span class="star">*</span></label>
                                <input name="amount" type="text" class="form-control" id="amount" value="<?php echo $coupon['amount']; ?>" required />
                            </div>
							<div class="form-group">
                                <label for="uses_total">Uses Total <span class="star">*</span></label>
                                <input name="uses_total" type="text" class="form-control" id="uses_total" value="<?php echo $coupon['uses_total']; ?>" required />
                            </div>
							<div class="form-group">
                                <label for="exp_date">Expired Date <span class="star">*</span></label>
                                <input name="exp_date" type="date" class="form-control" id="exp_date" value="<?php echo $coupon['exp_date']; ?>" required />
                            </div>
							
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0" <?php if($coupon['status']=="0"){ echo "selected='selected'"; } ?>>Disable</option>
									<option value="1" <?php if($coupon['status']=="1"){ echo "selected='selected'"; } ?>>Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="save_coupon" class="btn btn-success"><i class="fa fa-plus"></i> Update</button>
							<button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>