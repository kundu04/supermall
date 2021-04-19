<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Coupon
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Coupon</a>
                </li>
                <li class="active"> Add Coupon </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
        if(isset($_POST['add_coupon'])){
			
			$tableName = "coupon";
				$columnValue["title"] = $_POST['title'];
				$columnValue["code"] = $_POST['code'];
				$columnValue["type"] = $_POST['type'];
				$columnValue["amount"] = $_POST['amount'];
				$columnValue["uses_total"] = $_POST['uses_total'];
				$columnValue["exp_date"] = $_POST['exp_date'];
				$columnValue["status"] = $_POST['status'];
			
			$queryResult = $coreModel->insertData($tableName, $columnValue);
			
			if($queryResult['no_of_row_inserted'] > 0)
				{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully added Coupon named: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
    			}
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
                                <input required name="title" type="text" class="form-control" id="coupon_title" placeholder="Put coupon title" />
                            </div>
							<div class="form-group">
                                <label for="code">Coupon Code <span class="star">*</span></label>
                                <input name="code" type="text" class="form-control" id="code" placeholder="Put coupon code" required />
                            </div>
							<div class="form-group">
								<label for="type">Coupon Type <span class="star">*</span></label>
								<select id="type" required name="type" class="form-control m-bot15">
									<option value="0">R</option>
									<option value="1">P</option>
									<option value="2">E</option>
									<option value="3">B</option>
									<option value="4">V</option>
									<option value="5">S</option>
                                </select>
                            </div>
							<div class="form-group">
                                <label for="amount">Discount Amount <span class="star">*</span></label>
                                <input name="amount" type="text" class="form-control" id="amount" placeholder="Amount" required />
                            </div>
							<div class="form-group">
                                <label for="uses_total">Uses Total <span class="star">*</span></label>
                                <input name="uses_total" type="text" class="form-control" id="uses_total" placeholder="Put limit of total uses" required />
                            </div>
							<div class="form-group">
                                <label for="exp_date">Expired Date <span class="star">*</span></label>
                                <input name="exp_date" type="date" class="form-control" id="exp_date" required />
                            </div>
							
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0">Disable</option>
									<option value="1">Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="add_coupon" class="btn btn-success"><i class="fa fa-plus"></i> Add Coupon</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>