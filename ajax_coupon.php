<?php include("config.php") ?>
<?php
$code = $_GET['coupon'];
$coupon = $myModel->customQuery("SELECT * FROM coupon WHERE code='$code' AND status='1' AND exp_date >= '".date('Y-m-d')."'");

if(count($coupon)>0){
	$_SESSION['coupon_amount'] = $coupon[0]['amount'];
	echo $_SESSION['coupon_amount'];
}
else{
	echo "0";
	$_SESSION['coupon_amount'] = 0;
}

?>


 

