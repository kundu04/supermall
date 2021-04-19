<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");
extract($_GET);
 ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                List Orders
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Order</a>
                </li>
                <li class="active"> List Orders </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Orders
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-times"></a>
             </span>
        </header>
        <div class="panel-body">
        <div class="">
        <table style="width:100%" class="table table-bordered table-striped" id="datatable">
        <thead>
			<tr>
				<th>SL</th>
                <th>Order#</th>
				<th>Customer</th>
				<th>Mobile</th>
                <th>Total Amount</th>
                <th>Date Added</th>
                <th>Date Modified</th>
                <th>Order Status</th>
                <th>Action</th>
			</tr>
        </thead>
        <tbody>
		<?php 

        if(isset($_POST['save_order'])){
                
				$tableName = "order";
                $columnName["0"] = 'order_status_id';
                $whereValue["order_id"] = $_POST['order_id'];
				
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $ordStatus);

                if ($_POST['order_status_id'] == $ordStatus['order_status_id']) {
                    echo '
                    <div class="alert alert-danger fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         You have not changed the Order status !
                    </div>
                    ';
                }else{
				
					$columnValue["order_status_id"] = $_POST['order_status_id'];
					$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
                
					if($queryResult > 0)
					{
						echo '
						<div class="alert alert-success fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i></button>
								You have successfully changed the Order Status !
						</div>';
					}
				}
		}
		?>
		
		<?php
		
		if(isset($_GET['status_id']) && $_GET['status_id']!=''){
		
		$orderResult = $myModel->customQuery("SELECT * FROM `order`, `order_status`, `customer` WHERE `order`.order_status_id='$status_id' AND `order`.order_status_id=order_status.order_status_id AND `order`.customer_id=customer.customer_id ORDER BY `order`.order_id DESC");
		}
		else{
			$orderResult = $myModel->customQuery("SELECT * FROM `order`, `order_status`, `customer` WHERE `order`.order_status_id=order_status.order_status_id AND `order`.customer_id=customer.customer_id ORDER BY `order`.order_id DESC");
		}
		
		foreach($orderResult AS $key => $eachRow)
			{
			
				
			echo '<tr class="gradeX">
					<td>'.($key+1).'</td>
                    <td>'.$eachRow['order_id'].'</td>
					<td>'.$eachRow['cust_name'].'</td>
                    <td>'.$eachRow['phone'].'</td>
                    <td>'.$eachRow['total_amount'].'</td>
                    <td>'.$eachRow['date_added'].'</td>
                    <td>'.$eachRow['date_modified'].'</td>
                    <td><strong>'.$eachRow['name'].'</strong></td>                  
                    <td><button title="Change Status" data-toggle="modal" data-target="#myModal" orderId="'.$eachRow['order_id'].'" class="order_edit btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>
                        <a title="Order Details" class="btn btn-success btn-xs" href="invoice.php?order_id='.$eachRow['order_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                        
                    </td>
				</tr>';
			}				
		?>
        
        </tbody>
        
        </table>
        </div>
        </div>
        </section>
        </div>
        </div>

        </div>
        <!--body wrapper end-->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Order Status</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post">
            <div class="form-group">
				<label for="status">Order Status <span class="star">*</span></label>
				<select id="order_edit" required name="order_status_id" class="form-control m-bot15">
								
				</select>
				<div id="oId"></div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_order" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// get order id for change order status
$(document).ready(function(){
    $(".order_edit").click(function(){
        
		var id = $(this).attr('orderId');
		
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{get_order_id:id}
        }).done(function(data){
			
		   $("#order_edit").html(data);
		   $("#oId").html('<input name="order_id" type="hidden" value="'+id+'">');
        
		});
    });
});

</script>


<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>