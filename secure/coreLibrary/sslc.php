<?php
/*
	Model Name: SSLC
	Developed By: CloudyLine Team
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

class Sslc
{	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION ---------- ---------- ---------- */
	
	public function __construct()
	{
		//
	}
	
	/* ---------- ---------- ---------- Using iSMS ---------- ---------- ---------- */
	
	// Push SMS - Send //
	public function doPayment($sslcConfig)
	{
		if(!@$_POST['tran_id'])
		{
			if($sslcConfig['pay_type'] == "test")
				$sslcConfig['sslcommerz'] = "https://www.sslcommerz.com.bd/testbox/process/";
			else
				$sslcConfig['sslcommerz'] = "https://www.sslcommerz.com.bd/process/";
				
			echo "<form name=\"submit_sslcommerz\" action=\"".$sslcConfig['sslcommerz']."\" method=\"post\" id=\"submitFormNow\">";
				echo "<input type=\"hidden\" name=\"store_id\" value=\"". $sslcConfig['merchant_id'] ."\" />";
				echo "<input type=\"hidden\" name=\"tran_id\" value=\"". $sslcConfig['invoice_id'] ."\" />";
				echo "<input type=\"hidden\" name=\"total_amount\" value=\"". $sslcConfig['total_price'] ."\" />";
				echo "<input type=\"hidden\" name=\"success_url\" value=\"". $sslcConfig['return_page'] ."\" />";
				echo "<input type=\"hidden\" name=\"fail_url\" value=\"". $sslcConfig['return_page'] ."\" />";
				echo "<input type=\"hidden\" name=\"cancel_url\" value=\"". $sslcConfig['return_page']."?cancel=yes" ."\" />";
			echo "</form>";
			
			echo "
				<script type=\"text/javascript\">
					function payFunction () {
						var payForm = document.getElementById(\"submitFormNow\");
						payForm.submit();
					}
					window.onload = payFunction;
				</script>
			";
		}
	}
	
	public function checkPayment($pay_type)
	{
		$valid_id = @$_POST['val_id'];
		$tran_id = @$_POST['tran_id'];
		$cancel = @$_REQUEST['cancel'];
		
		if($cancel == "yes")
			return 3;
		else if(isset($tran_id))
		{
			if($pay_type == "test")
				$sslcGateway = 'https://www.sslcommerz.com.bd/testbox/validator/validationserver.php?wsdl';
			else if($pay_type == "real")
				$sslcGateway = 'https://www.sslcommerz.com.bd/validator/validationserver.php?wsdl';
			else
				return "As the second property of checkPayment() Function you have to send either 'test' or 'real'";
			
			try{
				$c = new soapclient($sslcGateway);
			}
			catch (Exception $e) {
				$errorFound = $e->getMessage();
			}
			
			$res = $c->checkValidation($valid_id);
			
			if (strcmp ($res, "VALID") == 0) {
				return 1;
			}
			else {
				return 2;
			}
		}
	}
}