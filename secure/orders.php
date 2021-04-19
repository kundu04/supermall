<?php include("fw-config.php") ?>
<?php ob_start(); ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                Orders
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Invoices</a>
                </li>
                <li class="active"> List Invoices </li>
                <li class="active"> Orders </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Order
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-times"></a>
             </span>
        </header>
        <div class="panel-body">
        <div class="">
        <table  class="table table-bordered table-striped" id="datatable">
        <thead>
			<tr>
				<th>#ID</th>
                <th>Invoice ID</th>
				<th>Customer Name</th>
				<th>Customer Email</th>
                <th>Customer Mobile</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
			</tr>
        </thead>
        <tbody>
		
		<?php

        if(isset($_POST['save_order']))
            {
                $tableName = "orders";
                $columnName["0"] = "ord_status";
                $whereValue["ord_id"] = $_POST['order_id'];
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $odrStatus);

                if ($_POST['status'] == $odrStatus['ord_status']) {
                    echo '
                    <div class="alert alert-danger fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Before you save, change the order status or cancel!
                    </div>
                    ';
                }

                $columnValue["ord_status"] = $_POST['status'];
                $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
                
                if($queryResult > 0)
                {
                    echo '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         You have successfully changed the order status: <strong>'.$_POST['status'].'</strong>
                    </div>
                    ';
                }
            }        

        if (isset($_GET['del']))
            {
                $tableName = "orders";
                $whereValue["ord_id"] = $_GET['del'];
                $queryResult = $coreModel->deleteData($tableName, $whereValue);
                if($queryResult > 0)
                {
                    echo '
                    <div class="alert alert-success fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i>
                        </button>
                        You have successfully deleted the order.
                    </div>
                    ';
                    header("Refresh: 2;url=invoice-list");
                    ob_end_flush();
                }
            }   
        
        if (isset($_GET['iid'])) {
            $invID = $_GET['iid'];
            $queryResult = $myModel->get_orders($invID);
            foreach($queryResult AS $eachRow)
            {
            echo '<tr class="gradeX">
                    <td>'.$eachRow['ord_id'].'</td>
                    <td>'.$eachRow['inv_id'].'</td>
                    <td>'.$eachRow['cust_fullname'].'</td>
                    <td>'.$eachRow['cust_email'].'</td>
                    <td>'.$eachRow['cust_mobile'].'</td>
                    <td>'.$eachRow['prod_price'].'</td>
                    <td>'.$eachRow['prod_qty'].'</td>
                    <td>'.$eachRow['ord_status'].'</td>
                    <td><button title="Change Status" data-toggle="modal" data-target="#myModal" value="'.$eachRow['ord_id'].'" class="odr_edit btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button> <a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['ord_id'].'"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>';
            }  
        }

        	
		?>
        
        </tbody>
        <tfoot>
        <tr>
			<th>#ID</th>
            <th>Invoice ID</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Mobile</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
		</tr>
        </tfoot>
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
            <div id="odr_edit" class="form-group">
                   
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
$(document).ready(function(){
    $(".odr_edit").click(function(){
        var odr_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{get_odr_id:odr_id}
        }).done(function(data){
           $("#odr_edit").html(data);
        });
    });
});

function conf() {
   
    if(confirm("Do you want to delete this Order?") == false){
        return false;
    }
}
</script>


<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>