<?php 
include("fw-config.php");

    if(isset($_POST['reset']))
    {   
        $tableName = "admin";
		$colunmName = '*';
        $whereValue["access_token"] = base64_decode($_POST['token']);
		$data = $coreModel->selectData($colunmName, $tableName, $whereValue);

        $past = $data[0]['time_diff'];
        $time = date("Y-m-d H:i:s",strtotime($past." +20 minutes"));
        $now = date("Y-m-d H:i:s");

        if ($now < $time) 
        {
            $salt = base64_encode(rand(10000, 99999));
            $newPass = $_POST['password'];
            $password = md5($salt.$newPass);
            $columnValue["salt"] = $salt;
            $columnValue['password'] = $password;
            $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);

            $_SESSION['mgs'] = 'Your password updated';
            header("Location:index");
        }
        else
        {
            $_SESSION['mgs'] = 'Your password reset link expired';
            header("Location:index");
        }

    }
         
?>
        