<?php 
	include("config.php"); 
		
		if(isset($_POST['change_pass']))
        {
			$tableName = "customer";
			$columnName = "*";
			$whereValue["customer_id"] = $_SESSION['cust_id'];
			$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
			foreach ($queryResult AS $customer);

        
            $oldSalt = $customer['salt'] . $_POST['current-pass'];
            $oldPass = md5($oldSalt);

            if ($oldPass == $customer['password']) {
                
                $salt = base64_encode(rand(10000, 99999));
                $newPass = $_POST['new-pass'];
                $password = md5($salt.$newPass);
                $columnValue["salt"] = $salt;
                $columnValue["password"] = $password;
                $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
            
                if($queryResult > 0)
                {
                    $_SESSION['mgs'] =  '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your password changed successfully!
                    </div>
                    ';
					header("Location:change-password.php");
                }
            }else{
              $_SESSION['mgs'] =  '
                <div class="alert alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                     Your current password did not matched!
                </div>
                ';
				header("Location:change-password.php");
            }
            
            
        }
	
	?>