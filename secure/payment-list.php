<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Payment Method
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Payment Method</a>
        </li>
        <li class="active"> List Payment Method </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
				<header class="panel-heading">
					List Payment Method
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
							<th>Payment Title</th>
							<th>Code</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					
					if (isset($_GET['del']))
					{
					$tableName = "payment_method";
					$columnName["0"] = "title";
					$whereValue["payment_id"] = $_GET['del'];
					$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
					foreach ($queryResult AS $paymentName);
					$queryResult = $coreModel->deleteData($tableName, $whereValue);
						if($queryResult > 0)
						{
						echo '
							<div class="alert alert-success alert-block fade in">
								<button type="button" class="close close-sm" data-dismiss="alert">
									<i class="fa fa-times"></i></button>You have successfully Deleted the Payment Method: <strong>'.$paymentName['title'].' </strong>
							</div> 
							';
						}
					}

					$columnName = "*";
					$tableName = "payment_method";
					$queryResult = $coreModel->selectData($columnName, $tableName);
					foreach($queryResult AS $key=>$eachRow)
					{
						if($eachRow['status']==1){$status = "Enable";}else{ $status = "Disable";}
					echo '
					<tr class="gradeX">
						<td>'.($key+1).'</td>
						<td>'.$eachRow['title'].'</td>
						<td>'.$eachRow['code'].'</td>
						<td>'.$status.'</td>
						<td>
							<a title="Edit" class="btn btn-info btn-xs" href="payment-edit.php?pid='.$eachRow['payment_id'].'"><i class="fa fa-pencil-square-o"></i></a>
							<a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['payment_id'].'"><i class="fa fa-trash-o"></i></a>
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
       
        if(confirm("Do you want to delete this Payment Method ?") == false){
                return false;
            }
        }
</script>

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>