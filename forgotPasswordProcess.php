<?php 
   include("config.php");
    if(isset($_POST['reset_pass']))
    {
        $tableName = "customer";
		$colunmName = '*';
        $whereValue["email"] = $_POST['email'];
		$data = $coreModel->selectData($colunmName, $tableName, $whereValue);
		
		if(!empty($data)){
        # CONFIGURE THE MAIL SETTINGS / CHECKING FROM YOUR cPANEL
        $mailConfig['host'] = MAIL_HOST_1;
        $mailConfig['port'] = MAIL_PORT_1;
        $mailConfig['email'] = OUTGOING_MAIL_ID_1;
        $mailConfig['pass'] = OUTGOING_MAIL_PASS_1;
        $mailConfig['name'] = "BITM Batch 1";
        $mailConfig['type'] = "text/html"; // "text/html";
        
        # PREPARE YOUR MAIL
        $mailDetails['title'] = "Reset Password";
		$rand_val = rand(10000, 99999);
		$access_token = base64_encode($rand_val);
		$columnValue['access_token'] = $rand_val;
		$columnValue['time_diff'] = date("Y-m-d H:i:s");
		$whereValue["customer_id"] = $data[0]['customer_id'];

	    $url = '<a href="localhost/supermall/reset-password.php?token='.$access_token.'"> Reset now</a>';
        $mailDetails['body'] = "Hello, ".$data[0]['cust_name']."<br><br>You have requested to reset your password.<br><br>You can reset your password by clicking the link within 30 minutes... ".$url;
        
        # PREPARE YOUR RECEIVERS
        $mailReceiver = $_POST['email'];
        # SEND THE MAIL
        $mailResult = $coreControl->smtpMail($mailConfig, $mailDetails, $mailReceiver);
		$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
		$_SESSION['mgs'] = 'Check your email to reset password';
		header('Location:forget-password.php');
		
		}
	    else{
			
			$_SESSION['mgs'] = 'Your Email did not match';
			header('Location:forget-password.php');

			
		}
		
        
    }
		 
?>
        