<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Admin Group
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">System Users Group</a>
                </li>
                <li class="active"> Add Admin Group</li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 

        if(isset($_POST['add_admin_group_rules']))
		{   
            $permission = implode(',', $_POST['permission']);
			$tableName = "admin_group";
            $columnValue["name"] = $_POST['name'];
            $columnValue["permission"] = $permission;
            $queryResult = $coreModel->insertData($tableName, $columnValue);
			if($queryResult['no_of_row_inserted'] > 0)
			{
				echo '
				<div class="alert alert-success fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					You have successfully added the admin group: <strong>'.$_POST['name'].'</strong>
				</div>
				';
			}
		}
		?>
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Add a new Admin Group
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group ">
                                <label class="control-label" for="name">Group Name <span class="star">*</span>
                                </label>
                                <div class="input-group">
                                    <input required class="form-control" id="name" name="name" placeholder="Enter group name" type="text"/>
                                    <div class="input-group-addon">
                                    <i class="fa fa-users">
                                    </i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label" for="name">Rules <span class="star">*</span> <span>( Select accessible pages )</span>
                                </label>
                                <ul class="list-group rules-list">
                                    <li class="list-group-item">
                                        Add Category
                                        <div class="material-switch pull-right">
                                            <input id="1" name="permission[]" value="add_category" type="checkbox"/>
                                            <label for="1" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Categories
                                        <div class="material-switch pull-right">
                                            <input id="1" name="permission[]" value="list_categories" type="checkbox"/>
                                            <label for="1" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Brand
                                        <div class="material-switch pull-right">
                                            <input id="3" name="permission[]" value="add_brand" type="checkbox"/>
                                            <label for="3" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Brands
                                        <div class="material-switch pull-right">
                                            <input id="4" name="permission[]" value="list_brands" type="checkbox"/>
                                            <label for="4" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Product
                                        <div class="material-switch pull-right">
                                            <input id="5" name="permission[]" value="add_product" type="checkbox"/>
                                            <label for="5" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Products
                                        <div class="material-switch pull-right">
                                            <input id="6" name="permission[]" value="list_products" type="checkbox"/>
                                            <label for="6" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Slider
                                        <div class="material-switch pull-right">
                                            <input id="7" name="permission[]" value="add_slider" type="checkbox"/>
                                            <label for="7" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Sliders
                                        <div class="material-switch pull-right">
                                            <input id="8" name="permission[]" value="list_sliders" type="checkbox"/>
                                            <label for="8" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Banner
                                        <div class="material-switch pull-right">
                                            <input id="9" name="permission[]" value="add_banner" type="checkbox"/>
                                            <label for="9" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Banners
                                        <div class="material-switch pull-right">
                                            <input id="10" name="permission[]" value="list_banners" type="checkbox"/>
                                            <label for="10" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Coupon
                                        <div class="material-switch pull-right">
                                            <input id="11" name="permission[]" value="add_coupon" type="checkbox"/>
                                            <label for="11" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Coupons
                                        <div class="material-switch pull-right">
                                            <input id="12" name="permission[]" value="list_coupons" type="checkbox"/>
                                            <label for="12" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Shipping
                                        <div class="material-switch pull-right">
                                            <input id="13" name="permission[]" value="add_shipping" type="checkbox"/>
                                            <label for="13" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Shippings
                                        <div class="material-switch pull-right">
                                            <input id="14" name="permission[]" value="list_shippings" type="checkbox"/>
                                            <label for="14" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Payment Method
                                        <div class="material-switch pull-right">
                                            <input id="15" name="permission[]" value="add_payment_method" type="checkbox"/>
                                            <label for="15" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Payment Methods
                                        <div class="material-switch pull-right">
                                            <input id="16" name="permission[]" value="list_payment_methods" type="checkbox"/>
                                            <label for="16" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Customer
                                        <div class="material-switch pull-right">
                                            <input id="17" name="permission[]" value="add_customer" type="checkbox"/>
                                            <label for="17" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Customers
                                        <div class="material-switch pull-right">
                                            <input id="18" name="permission[]" value="list_customers" type="checkbox"/>
                                            <label for="18" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Order
                                        <div class="material-switch pull-right">
                                            <input id="19" name="permission[]" value="add_order" type="checkbox"/>
                                            <label for="19" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Orders
                                        <div class="material-switch pull-right">
                                            <input id="20" name="permission[]" value="list_orders" type="checkbox"/>
                                            <label for="20" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Admin
                                        <div class="material-switch pull-right">
                                            <input id="23" name="permission[]" value="add_admin" type="checkbox"/>
                                            <label for="23" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Admins
                                        <div class="material-switch pull-right">
                                            <input id="24" name="permission[]" value="list_admins" type="checkbox"/>
                                            <label for="24" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Add Admin Group
                                        <div class="material-switch pull-right">
                                            <input id="25" name="permission[]" value="add_admin_group" type="checkbox"/>
                                            <label for="25" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        List Admin Groups
                                        <div class="material-switch pull-right">
                                            <input id="26" name="permission[]" value="list_admin_groups" type="checkbox"/>
                                            <label for="26" class="label-success"></label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <div>
                                 <button class="btn btn-success" name="add_admin_group_rules" type="submit"><i class="fa fa-plus"></i> Add Admin Group</button>
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