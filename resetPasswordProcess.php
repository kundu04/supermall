<?php 
include("config.php");

    if(isset($_POST['reset']))
    {   
        $tableName = "customer";
		$colunmName = '*';
        $whereValue["access_token"] = base64_decode($_POST['token']);
		$data = $coreModel->selectData($colunmName, $tableName, $whereValue);

        $past = $data[0]['time_diff'];
        $time = date("Y-m-d H:i:s",strtotime($past." +30 minutes"));
        $now = date("Y-m-d H:i:s");

        if ($now < $time) 
        {
            $salt = base64_encode(rand(10000, 99999));
            $Pass = $_POST['new-pass'];
            $password = md5($salt.$Pass);
            $columnValue["salt"] = $salt;
            $columnValue['password'] = $password;
            $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);

            $_SESSION['mgs'] = 'Your password updated';
            header("Location:login.php");
        }
        else
        {
            $_SESSION['mgs'] = 'Your password reset link expired';
            header("Location:login.php");
        }

    }
         
?>
        