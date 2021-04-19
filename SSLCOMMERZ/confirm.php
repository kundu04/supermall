<?php
# RETURN PAGE FROM SSLCOMMERZ
include_once "SSLCommerz.php";

# SSLCommerz(STORE ID,STORE PASSWORD, SANDBOX MODE)
# Ex. SSLCommerz(STORE ID,STORE PASSWORD, 1), 1= Means to check in Sandbox and 0=Means to Check in Live
$sslc = new SSLCommerz();

# PASS THE TRANSACTION ID , AMOUNT, CURRENCY TYPE FROM YOUR SYSTEM (NOT WHICH ARE RETURNED BY SSLCOMMERZ)
$validation = $sslc->orderValidate($transaction_id, $amount, $currency, $_POST);

# EXAMPLE TO TEST
$validation = $sslc->orderValidate($_POST['tran_id'], $_POST['amount'], $_POST['currency_type'], $_POST);


var_dump($validation);