<?php include("fw-config.php") ?>
<?php  

        $tableName = "admin";
        $columnName = "*";
        $whereValue["admin_id"] = $_SESSION['admin_id'];
        $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
        foreach ($queryResult AS $admin);

        if(isset($_POST['save']))
        {
            $columnValue["name"] = $_POST['name'];
            $columnValue["email"] = $_POST['email'];
            $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
            if($queryResult > 0)
            {
			         $_SESSION['admin_name'] = $_POST['name'];
               $mgs =  '
                <div class="alert alert-success fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                     Your profile successfully saved!
                </div>
                ';
            }
        }

        if(isset($_POST['change_pass']))
        {
            $oldSalt = $admin['salt'] . $_POST['current-pass'];
            $oldPass = md5($oldSalt);

            if ($oldPass == $admin['password']) {
                
                $salt = base64_encode(rand(10000, 99999));
                $newPass = $_POST['new-pass'];
                $password = md5($salt.$newPass);
                $columnValue["salt"] = $salt;
                $columnValue["password"] = $password;
                $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
            
                if($queryResult > 0)
                {
                    $mgs =  '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your password changed successfully!
                    </div>
                    ';
                }
            }else{
              $mgs =  '
                <div class="alert alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                     Your password did not matched!
                </div>
                ';
            }
            
            
        }
        ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
              Admin Profile
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">System Users</a>
                </li>
                <li class="active"> Admin Profile </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->

        <?php if(isset($mgs)){ echo $mgs; } ?>
		
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
			
                <section class="panel">
                    <header class="panel-heading">
                        Admin Information
                    </header>
                    <div class="panel-body">
                        <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab">
                                    <div class=""><i class="fa fa-user"></i> Profile</div>
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab">
                                    <div class=""><i class="fa fa-edit"></i> Edit</div>
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab">
                                    <div class=""><i class="fa fa-cog"></i> Settings</div>
                                </button>
                            </div>
                        </div>

                        <div class="well">
                          <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1">
                              <table class="table table-user-information">
                                <tbody>
                                  <tr>
                                    <td><b>Name:</b></td>
                                    <td><?php echo $admin['name']; ?></td>
                                  </tr>
                                  <tr>
                                    <td><b>Email:</b></td>
                                    <td><?php echo $admin['email']; ?></td>
                                  </tr>
                                  <tr>
                                    <td><b>Type:</b></td>
                                    <td><?php echo $admin['admin_type']; ?></td>
                                  </tr>
                                  <tr>
                                    <td><b>Status:</b></td>
                                    <td><?php echo $admin['status']; ?></td>
                                  </tr>

                                </tbody>
                              </table>
                            </div>
                            <div class="tab-pane fade in" id="tab2">
                              <form name="myForm" action="" method="post">
                                  <div class="form-group ">
                                    <label class="control-label" for="name">Name <span class="star">*</span>
                                    </label>
                                    <div class="input-group">
                                      <input value="<?php echo $admin['name']; ?>" required class="form-control" id="name" name="name" placeholder="Enter name" type="text"/>
                                      <div class="input-group-addon">
                                      <i class="fa fa-user">
                                      </i>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group ">
                                    <label  class="control-label" for="email">Email Address <span class="star">*</span>
                                    </label>
                                    <div class="input-group">
                                      <input value="<?php echo $admin['email']; ?>" class="form-control" id="email" name="email" placeholder="Enter email" type="email"/>
                                      <div class="input-group-addon">@</div>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <div style="margin-top: 30px;">
                                     <button class="btn btn-success" name="save" type="submit"><i class="fa fa-paper-plane"></i> Save</button>
                                     <button class="btn btn-danger" name="cancel" type="reset"> Cancel</button>
                                    </div>
                                  </div><br>

                                </form>
                            </div>
                            <div class="tab-pane fade in" id="tab3">
                            
                              <form name="myForm" action="" method="post">
                                  <div class="form-group ">
                                    <label class="control-label" for="current-pass">Current password <span class="star">*</span>
                                    </label>
                                    <div class="input-group">
                                      <input required class="form-control" id="current-pass" name="current-pass" placeholder="Current password..." type="password"/>
                                      <div class="input-group-addon">
                                      <i class="fa fa-lock">
                                      </i>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group ">
                                    <label class="control-label" for="current-pass">New password <span class="star">*</span>
                                    </label>
                                    <div class="input-group">
                                      <input required class="form-control" id="new-pass" name="new-pass" placeholder="New password..." type="password"/>
                                      <div class="input-group-addon">
                                      <i class="fa fa-lock">
                                      </i>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group ">
                                    <label class="control-label" for="current-pass">Confirm password <span class="star">*</span>
                                    </label>
                                    <div class="input-group">
                                      <input class="form-control" id="conf-pass" name="conf-pass" placeholder="Confirm password..." type="password"/>
                                      <div class="input-group-addon">
                                      <i class="fa fa-lock">
                                      </i>
                                      </div>
                                    </div>
                                  </div><br />

                                  <div class="form-group">
                                    <div>
                                     <button class="btn btn-success" name="change_pass" type="submit"><i class="fa fa-paper-plane"></i> Change password</button>
                                     <button class="btn btn-danger" name="cancel" type="reset"> Cancel</button>
                                    </div>
                                  </div><br>

                                </form>
                            </div>
                          </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

<script>
    $(document).ready(function() {
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        // $(".tab").addClass("active"); // instead of this do the below 
        $(this).removeClass("btn-default").addClass("btn-primary");   
    });
    });
</script>
<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>