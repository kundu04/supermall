<?php
/*
	Model Name: SMS
	Developed By: CloudyLine Team
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

class Sms
{	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION ---------- ---------- ---------- */
	
	public function __construct()
	{
		//
	}
	
	/* ---------- ---------- ---------- Using iSMS ---------- ---------- ---------- */
	
	// Push SMS - Send //
	public function iSmsSend($iSmsConfig, $iSmsBody, $iSmsNos)
	{
		$iSmsUser = $iSmsConfig['user'];
		$iSmsPass = $iSmsConfig['pass'];
		$iSmsSID = $iSmsConfig['sid'];
		$iSmsURL = $iSmsConfig['url'];
		$iSmsCSMSID = $iSmsConfig['csmsid'];
		
		$param1 = "user=".$iSmsUser."&pass=".$iSmsPass."&sid=".$iSmsSID.""; $param2 = "";
		
		for($sl = 0 ; $sl < count($iSmsNos) ; $sl++)
		{
			$param2 .= "&sms[$sl][0]=".$iSmsNos[$sl]."&sms[$sl][1]=".urlencode($iSmsBody)."&sms[$sl][2]=".$iSmsCSMSID;
		}
		$param = $param1 . $param2;
		
		$crl = curl_init(); 
		curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,FALSE); 
		curl_setopt($crl,CURLOPT_SSL_VERIFYHOST,2); 
		curl_setopt($crl,CURLOPT_URL,$iSmsURL); 
		curl_setopt($crl,CURLOPT_HEADER,0); 
		curl_setopt($crl,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($crl,CURLOPT_POST,1); 
		curl_setopt($crl,CURLOPT_POSTFIELDS,$param); 
		$response = curl_exec($crl); 
		curl_close($crl); 
		# echo $response;
		
		if (strpos($response, "OKSUCCESSFULLACTIVEOKOK") !== true)
		{
			return 1;
		}
		else 
		{
			return 0;
		}
	}
}