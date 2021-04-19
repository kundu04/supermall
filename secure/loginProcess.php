<?php 
   include("fw-config.php");
     if(isset($_POST['email']))
            {
                $tableName = "admin";
				$colunmName = '*';
                $whereValue["email"] = $_POST['email'];
				
				$data = $coreModel->selectData($colunmName, $tableName, $whereValue);
				if(!empty($data)){
					$password = $data[0]['salt'].$_POST['password'];
					if($data[0]['password'] == md5($password)){
						
						$_SESSION['admin_id'] =   $data[0]['admin_id'];
						$_SESSION['admin_name'] = $data[0]['name'];
						$_SESSION['admin_type'] = $data[0]['admin_type'];
						$_SESSION['admin_email'] = $data[0]['email'];
						$_SESSION['admin_status'] = $data[0]['status'];
						
						header("Location:admin-profile");
					}
				    else{
						$_SESSION['mgs'] = 'Your Password did not match';
						header("Location:index");
					}
					
				}
			    else{
					
					$_SESSION['mgs'] = 'Your Email did not match';
					 header("Location:index");
				}
				
                
            }
		 else{
			 header("Location:index");
		 }
        ?>
        