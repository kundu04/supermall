<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Admin
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">System Users</a>
                </li>
                <li class="active"> Add Admin </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
		
		<?php 

        if(isset($_POST['add_admin']))
		{   
            $salt = base64_encode(rand(10000, 99999));
            $autoPass = $coreControl->makePass();
            $password = md5($salt.$autoPass);

			$tableName = "admin";
            $columnValue["name"] = $_POST['name'];
            $columnValue["email"] = $_POST['email'];
            $columnValue["salt"] = $salt;
            $columnValue["password"] = $password;
            $columnValue["admin_group_id"] = $_POST['group_id'];
			
            # CONFIGURE THE MAIL SETTINGS / CHECKING FROM YOUR cPANEL
            $mailConfig['host'] = MAIL_HOST_1;
            $mailConfig['port'] = MAIL_PORT_1;
            $mailConfig['email'] = OUTGOING_MAIL_ID_1;
            $mailConfig['pass'] = OUTGOING_MAIL_PASS_1;
            $mailConfig['name'] = "BITM Batch 1";
            $mailConfig['type'] = "text/html"; // "text/html";
            
            # PREPARE YOUR MAIL
            $mailDetails['title'] = "Signup Success! Your... Username & Password";
            $mailDetails['body'] = "Hello, ".$_POST['name']."<br /><br />Welcome to BITM Batch 1 as admin <br /><br />Login Link: <a href='localhost/supermall/secure/index.php'>Login</a><br /><br />Username: ".$_POST['email']."<br /><br />Password: ".$autoPass."<br /><br />Please remember this login details for further use.";
            
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
						<i class="fa fa-times"></i>
					</button>
					You have successfully added the admin named: <strong>'.$_POST['name'].'</strong>
				</div>
				';
			}
		}
		?>
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Add a new Admin
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
                            <label for="type">Admin Group <span class="star">*</span></label>
                                <select id="type" required name="group_id" class="form-control m-bot15">
                                    <option value="">Select Group</option>
                                    <?php 
                                    $tableName = "admin_group";
                                    $columnName["1"] = "admin_group_id";
                                    $columnName["2"] = "name";
                                    $queryResult = $coreModel->selectData($columnName, $tableName);
                                    foreach ($queryResult as $groupList) {
                                        $groupId = $groupList['admin_group_id'];
                                        $groupName = $groupList['name'];
                                        echo "<option value='$groupId'>$groupName</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <div>
                                 <button class="btn btn-success" name="add_admin" type="submit"><i class="fa fa-plus"></i> Add Admin</button>
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