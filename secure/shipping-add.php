<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Shipping Method
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Shipping Method</a>
                </li>
                <li class="active"> Add Shipping Method </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 
        if(isset($_POST['add_shipping']))
    		{
    			$tableName = "shipping_method";
                $columnValue["title"] = $_POST['title'];
                $columnValue["amount"] = $_POST['amount'];
                $columnValue["status"] = $_POST['status'];

                $queryResult = $coreModel->insertData($tableName, $columnValue);
    			
    			if($queryResult['no_of_row_inserted'] > 0)
    			{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i>
    					</button>
    					You have successfully added shipping Method: <strong>'.$_POST['title'].'</strong>
    				</div>
    				';
    			}
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
                                <input required name="title" type="text" class="form-control" id="shipping_title" placeholder="Put shipping title" />
                            </div>
							
							<div class="form-group">
                                <label for="amount">Amount <span class="star">*</span></label>
                                <input name="amount" type="text" class="form-control" id="amount" placeholder="Amount" required />
                            </div>
														
							<div class="form-group">
								<label for="status">Status <span class="star">*</span></label>
								<select id="status" required name="status" class="form-control m-bot15">
									<option value="0">Disable</option>
									<option value="1">Enable</option>
			                   </select>
                            </div>
							<div class="clearfix"></div>
                           
                            <button type="submit" name="add_shipping" class="btn btn-success"><i class="fa fa-plus"></i> Add Shipping</button>
                        </form>

                    </div>
                </section>
            </div>
        </div>

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>