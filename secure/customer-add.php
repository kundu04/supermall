<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Customer
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Customer</a>
                </li>
                <li class="active"> Add Customer </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 

        if(isset($_POST['add_customer']))
    		{   
                $salt = base64_encode(rand(10000, 99999));
                $autoPass = $coreControl->makePass();
                $password = md5($salt.$autoPass);

    			$tableName = "customer";
    			$columnValue["cust_name"] = $_POST['name'];
                $columnValue["email"] = $_POST['email'];
                $columnValue["salt"] = $salt;
                $columnValue["password"] = $password;
    			
                # CONFIGURE THE MAIL SETTINGS / CHECKING FROM YOUR cPANEL
                $mailConfig['host'] = MAIL_HOST_1;
                $mailConfig['port'] = MAIL_PORT_1;
                $mailConfig['email'] = OUTGOING_MAIL_ID_1;
                $mailConfig['pass'] = OUTGOING_MAIL_PASS_1;
                $mailConfig['name'] = "Supermall";
                $mailConfig['type'] = "text/html"; // "text/html";
                
                # PREPARE YOUR MAIL
                $mailDetails['title'] = "Signup Success! Your... Username & Password";
                $mailDetails['body'] = "Hello, ".$_POST['name']."<br /><br />Welcome to Supermall<br /><br />Login Link: <a href='localhost/supermall/index.php'>Login</a><br /><br />Username: ".$_POST['email']."<br /><br />Password: ".$autoPass."<br /><br />Please remember this user login details for further use.";
                
                # PREPARE YOUR RECEIVERS
                $mailReceiver = $_POST['email'];
                # SEND THE MAIL
                $mailResult = $coreControl->smtpMail($mailConfig, $mailDetails, $mailReceiver);

                $queryResult = $coreModel->insertData($tableName, $columnValue);
    			
    			if($queryResult['no_of_row_inserted'] > 0 && $mailResult)
    			{
    				echo '
    				<div class="alert alert-success fade in">
    					<button type="button" class="close close-sm" data-dismiss="alert">
    						<i class="fa fa-times"></i></button>
    					 You have successfully added the customer named: <strong>'.$_POST['name'].'</strong>
    				</div>
    				';
    			}
    		}
		?>
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Add a new Customer
                    </header>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group ">
                                <label class="control-label" for="name">Full Name <span class="star">*</span>
                                </label>
                                <div class="input-group">
                                    <input required class="form-control" id="name" name="name" placeholder="Enter full name" type="text"/>
                                    <div class="input-group-addon">
                                    <i class="fa fa-user">
                                    </i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label" for="email">Email Address <span class="star">*</span>
                                </label>
                                <div class="input-group">
                                    <input required class="form-control" id="email" name="email" placeholder="Enter email" type="email"/>
                                    <div class="input-group-addon">@</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                 <button class="btn btn-success" name="add_customer" type="submit"><i class="fa fa-plus"></i> Add Customer</button>
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