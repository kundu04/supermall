<?php include("config.php"); ?>
<?php 
include_once("SSLCOMMERZ/SSLCZConfig.php"); 
include_once "SSLCOMMERZ/SSLCommerz.php";
?>
<?php

extract($_POST);

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();


$order_id = $myModel->insertQuery("INSERT INTO `order` (`customer_id`, `payment_method`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_zipcode`, `shipping_country`, `shipping_amount`, `comment`, `total_amount`, `order_status_id`, `ip`) VALUES
('".$_SESSION['cust_id']."', '$payment_method', '$ship_name', '$ship_phone', '$ship_address', '$ship_city', '$ship_zipcode', '$ship_country', '$shipping_amount', '', '$amount', 1, '$user_ip')");


foreach($_SESSION['cart'] as $key=>$cart){
	 $product_name[] = $cart['name'];
	 $product_id[] = $key;
	$total = $cart['quantity'] * $cart['price'];
	$myModel->insertQuery("INSERT INTO `order_product` (`order_id`, `product_id`, `name`, `quantity`, `price`, `total`) VALUES
	('$order_id', '$key', '".$cart['name']."', '".$cart['quantity']."', '".$cart['price']."', '$total')");
}

$address_id = $myModel->insertQuery("INSERT INTO `address` (`customer_id`, `name`,`phone`, `address`, `city_id`, `country_id`,`zipcode`) VALUES
('".$_SESSION['cust_id']."', '$ship_name', '$ship_phone', '$ship_address', '$ship_city', '$ship_country', '$ship_zipcode')");

$columnName["address_id"] = $address_id;							
$coreModel->updateData("customer", $columnName, array("customer_id"=>$_SESSION['cust_id']));

if($payment_method=='bank'){
	
$post_data = array();
$post_data['total_amount'] = $amount;
$post_data['currency'] = "BDT";
$post_data['tran_id'] = $order_id;
$post_data['success_url'] = "http://localhost/supermall/orderSuccess.php";
$post_data['fail_url'] = "http://localhost/supermall/orderSuccess.php";
$post_data['cancel_url'] = "http://localhost/supermall/checkout.php";

# CUSTOMER INFORMATION
$post_data['cus_name'] = $ship_name;
$post_data['cus_email'] = "cust@email.com";
$post_data['cus_add1'] = $ship_address;
$post_data['cus_add2'] = "";
$post_data['cus_city'] = $ship_city;
$post_data['cus_state'] = "";
$post_data['cus_postcode'] = $ship_zipcode;
$post_data['cus_country'] = $ship_country;
$post_data['cus_phone'] = $ship_phone;
$post_data['cus_fax'] = "";

# SHIPMENT INFORMATION
$post_data['ship_name'] = $ship_name;
$post_data['ship_add1 '] = $ship_address;
$post_data['ship_add2'] = "";
$post_data['ship_city'] = $ship_city;
$post_data['ship_state'] = "";
$post_data['ship_postcode'] = $ship_zipcode;
$post_data['ship_country'] = $ship_country;
# OPTIONAL PARAMETERS
$post_data['value_a'] = "ref001";
$post_data['value_b'] = "ref002";
$post_data['value_c'] = "ref003";
$post_data['value_d'] = "ref004";

# SSLCommerz(STORE ID,STORE PASSWORD, SANDBOX MODE)
# Ex. SSLCommerz(STORE ID,STORE PASSWORD, 1), 1= Means to check in Sandbox and 0=Means to Check in Live
$sslc = new SSLCommerz();

# initiate(Transaction Data , Whether redirect or Display in Page)
$options = $sslc->initiate($post_data, true);
echo "<br> Bank Card<br />";
foreach($options['cards'] as $value){
	
echo $value['link'].' ';
}
echo "<br> Internet Banking<br />";
foreach($options['internet'] as $value){
	
echo $value['link'].' ';
}

echo "<br> Mobile Banking<br />";
foreach($options['mobile'] as $value){
	
echo $value['link'].' ';
}
}
else if($payment_method=='paypal'){
	
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypalID = 'jonysekhrtl@gmail.com'; //Business Email
	?>
	
	<form action="<?php echo $paypalURL; ?>" method="post" id="frm">
        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
        
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        
        <!-- Specify details about the item that buyers will purchase. --> 
		<?php for($i=0; $i<count($product_name); $i++){ ?>
        <input type="hidden" name="item_name[]" value="<?php echo $product_name[$i]; ?>">
		<input type="hidden" name="item_number[]" value="<?php echo $product_id[$i]; ?>">
		<?php } ?>
        
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
        <input type="hidden" name="currency_code" value="USD">
        
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/supermall/checkout.php'>
        <input type='hidden' name='return' value='http://localhost/supermall/orderSuccess.php'>
        
        <!-- Display the payment button. -->
        <!-- <input type="submit" name="submit"  value="Go"> -->
		
    </form>

	<script>
	
	window.onload = function (){ document.getElementById("frm").submit(); }
	
	</script>
	<?php
	
	
}
else{
header("Location:orderSuccess.php");
}

?>


 

