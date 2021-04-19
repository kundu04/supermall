<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Invoice
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Invoices</a>
                </li>
                <li class="active"> Add Invoice </li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <?php 
        if(isset($_POST['add_invoice']))
            {
                $tableName = "invoices";
                $columnValue["cust_id"] = 1;
                $columnValue["inv_status"] = $_POST['status'];
                $columnValue["inv_total"] = $_POST['total'];
                
                $queryResult = $coreModel->insertData($tableName, $columnValue);
                
                if($queryResult['no_of_row_inserted'] > 0)
                {
                
                    echo '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                        You have successfully added a new invoice
                    </div>
                    ';
                }
            }
        ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Add a new Invoice
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                            <label for="status">Invoice Status <span class="star">*</span></label>
                                <select id="status" required name="status" class="form-control m-bot15">
                                    <option value="Processing">Processing</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                            <div class="form-group ">
                                <label class="control-label" for="total">Total <span class="star">*</span>
                                </label>
                                <div class="input-group">
                                    <input required class="form-control" id="total" name="total" placeholder="Enter invoice total" type="number"/>
                                    <div class="input-group-addon">
                                      <i class="fa fa-pencil">
                                      </i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                 <button class="btn btn-success" name="add_invoice" type="submit"><i class="fa fa-plus"></i> Add Invoice</button>
                                 <button class="btn btn-danger" name="cancel" type="reset"> Cancel</button>
                                </div>
                            </div>
                            
                        </form>

                    </div>
                </section>
            </div>
        </div>

		
<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>