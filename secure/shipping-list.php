<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Shipping Method
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Shipping Method</a>
        </li>
        <li class="active"> List Shipping Method </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
				<header class="panel-heading">
					List Shipping Method
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
							<th>SL</th>
							<th>Shipping Title</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					
					if (isset($_GET['del']))
					{
					$tableName = "shipping_method";
					$columnName["0"] = "title";
					$whereValue["coupon_id"] = $_GET['del'];
					$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
					foreach ($queryResult AS $shippingName);
					$queryResult = $coreModel->deleteData($tableName, $whereValue);
						if($queryResult > 0)
						{
						echo '
							<div class="alert alert-success alert-block fade in">
								<button type="button" class="close close-sm" data-dismiss="alert">
									<i class="fa fa-times"></i></button>You have successfully Deleted the Shipping Method: <strong>'.$shippingName['title'].' </strong>
							</div> 
							';
						}
					}

					$columnName = "*";
					$tableName = "shipping_method";
					$queryResult = $coreModel->selectData($columnName, $tableName);
					foreach($queryResult AS $key=>$eachRow)
					{
						if($eachRow['status']==1){$status = "Enable";}else{ $status = "Disable";}
					echo '
					<tr class="gradeX">
						<td>'.($key+1).'</td>
						<td>'.$eachRow['title'].'</td>
						<td>'.$eachRow['amount'].'</td>
						<td>'.$status.'</td>
						<td>
							<a title="Edit" class="btn btn-info btn-xs" href="shipping-edit.php?sid='.$eachRow['shipping_id'].'"><i class="fa fa-pencil-square-o"></i></a>
							<a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['shipping_id'].'"><i class="fa fa-trash-o"></i></a>
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

<script>
    function conf() {
       
        if(confirm("Do you want to delete this Shipping Method ?") == false){
                return false;
            }
        }
</script>

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>