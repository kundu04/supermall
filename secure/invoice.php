<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php
if(isset($_GET['order_id'])){
    
    $coreModel->updateData("order", array("read_status"=>1), array("order_id"=>$_GET['order_id']));
    
} 
include("includeFile/content-header.php"); 

?>
<?php
    if(isset($_REQUEST['order_id']) && $_REQUEST['order_id'] !=""){
              
        $custDetails = $myModel->customQuery("SELECT cust.cust_name, cust.email, cust.phone, cust.address, country.name as cust_country, city.name as cust_city FROM customer as cust, country, city, `order`
        WHERE cust.customer_id = `order`.customer_id AND cust.country_id = country.country_id AND cust.city_id = city.city_id LIMIT 1");
        foreach($custDetails as $key => $custDetail);
                
        $order_id = $_REQUEST['order_id'];
        
        $orderDetails = $myModel->customQuery("SELECT o.*, oS.name as status, country.name as ship_country, city.name as ship_city FROM `order` as o, order_status as oS, country, city 
        WHERE o.order_id = '$order_id' AND o.order_status_id = oS.order_status_id AND o.shipping_country = country.country_id AND o.shipping_city = city.city_id LIMIT 1");
        
        foreach($orderDetails as $key => $orderDetail);
                
        $proDetails = $myModel->customQuery("SELECT * FROM order_product WHERE order_id = '$order_id'");
                    
    }
?>
       
        <!--body wrapper start-->
        <div class="wrapper">

            <div class="panel">
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h1 class="invoice-title">invoice</h1>
                        </div>
                        <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                            <h1 class="inv-to"><b>SUPERMALL</b></h1>
                            <p> Dhaka, Bangladesh <br/>
                                Phone: +8801978826000</p>
                        </div>
                    </div>
                    <div class="invoice-address">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to">Invoice To</h4>
                                <h2 class="corporate-id"><?php echo $custDetail['cust_name']; ?></h2>
                                <?php echo $custDetail['address']; ?><br>
                                <?php echo $custDetail['cust_city']. ', '. $custDetail['cust_country'];?><br>
                                <?php echo $custDetail['phone'];?><br>  
                                </p>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to">Shipment To</h4>
                                <h2 class="corporate-id"><?php echo $orderDetail['shipping_name'];?></h2>
                                <p>
                                    <?php echo $orderDetail['shipping_address']; ?><br>
                                <?php echo $orderDetail['ship_city']. ', '. $orderDetail['ship_country'];?><br>
                                <?php echo $orderDetail['shipping_phone'];?>
                                </p>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="inv-col"><span>Invoice#</span> 432134-A</div>
                                <div class="inv-col"><span>Invoice Date :</span> <?php echo $orderDetail['date_added']; ?></div>
                                <div class="inv-col"><span>Payment Method:</span><?php echo $orderDetail['payment_method'];?></div>
                                <?php if($orderDetail['payment_method'] != 'cash' && $orderDetail['status'] != 'Pending'){ 
                                    $payStatus = 'PAID';
                                }
                                    
                                elseif($orderDetail['payment_method'] == 'cash' && $orderDetail['status'] == 'Complete'){
                                    $payStatus = 'PAID';
                                }else{
                                    $payStatus = 'TOTAL DUE';} ?>
                                                                                                
                                <h1 class="t-due"><?php echo $payStatus; ?></h1>
                                <h2 class="amnt-value"><?php echo 'BDT '. $orderDetail['total_amount']; ?></h2>
                                <h4>Order Status: <?php echo $orderDetail['status']; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-invoice">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Item Description</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($proDetails as $key => $proDetail){ ?>
                    <tr>
                        <td><?php echo ($key+1); ?></td>
                        <td>
                            <p><?php echo $proDetail['name']; ?></p>
                            
                        </td>
                        <td class="text-center"><strong><?php echo $proDetail['price']; ?></strong></td>
                        <td class="text-center"><strong><?php echo $proDetail['quantity']; ?></strong></td>
                        <td class="text-center"><strong><?php echo $proDetail['total']; ?></strong></td>
                    </tr>
                    <?php } ?>
                    
                    
                    <tr>
                        <td colspan="2" class="payment-method">
                            
                        </td>
                        <td class="text-right" colspan="2">
                            <p>Sub Total</p>
                            <p>Shipping Charge (+)</p>
                            <p><strong>GRAND TOTAL</strong></p>
                        </td>
                        <?php $subtotal = $orderDetail['total_amount']-@$orderDetail['shipping_amount']; ?>
                        <td class="text-center">
                            <p><?php echo number_format($subtotal, 2, '.', ''); ?></p>
                            <p><?php echo @$orderDetail['shipping_amount']; ?></p>
                            <p><strong><?php echo 'BDT '. $orderDetail['total_amount'];?></strong></p>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="text-center ">
                <a class="btn btn-success btn-lg"><i class="fa fa-download"></i> Download </a>
                <a class="btn btn-primary btn-lg" ><i class="fa fa-print"></i> Print </a>
            </div>

        </div>
        <!--body wrapper end-->

<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>