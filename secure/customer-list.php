<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
	<h3>
         List Customers
    </h3>
    <ul class="breadcrumb">
		<li>
			<a href="#">Customers</a>
        </li>
        <li class="active"> List Customers </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
	<div class="row">
		<div class="col-sm-12">
			<section class="panel">
				<header class="panel-heading">
					Customers
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
								<th>Full Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Status</th>
								<th>Sign Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
		
					<?php 

					if (isset($_GET['blc']))
						{ 
							$tableName = "customer";
							$columnName["0"] = "cust_name";
							$columnName["1"] = "status";
							$whereValue["customer_id"] = $_GET['blc'];
							$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
							foreach ($queryResult AS $custBlc);
			
							$columnValue["status"] = 'Inactive';
							$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
							echo '
								<div class="alert alert-success alert-block fade in">
									<button type="button" class="close close-sm" data-dismiss="alert">
										<i class="fa fa-times"></i></button>
								You have successfully Blocked the customer named: <strong>'.$custBlc['cust_name'].' </strong>
								</div> 
							';     
						}

					if (isset($_GET['unblc']))
						{
							$tableName = "customer";
							$columnName["0"] = "cust_name";
							$columnName["1"] = "status";
							$whereValue["customer_id"] = $_GET['unblc'];
							$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
							foreach ($queryResult AS $custUblc);
			
							$columnValue["status"] = 'Active';
							$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
							echo '
								<div class="alert alert-success alert-block fade in">
									<button type="button" class="close close-sm" data-dismiss="alert">
										<i class="fa fa-times"></i></button>
									You have successfully Actived the customer named: <strong>'.$custUblc['cust_name'].' </strong>
								</div> 
							';     
						}

					if (isset($_GET['del']))
						{
							$tableName = "customer";
							$columnName["0"] = "cust_name";
							$whereValue["customer_id"] = $_GET['del'];
							$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
							foreach ($queryResult AS $custName);
							$queryResult = $coreModel->deleteData($tableName, $whereValue);
							if($queryResult > 0)
							{
							echo '
								<div class="alert alert-success alert-block fade in">
									<button type="button" class="close close-sm" data-dismiss="alert">
										<i class="fa fa-times"></i></button>
								You have successfully Deleted the customer named: <strong>'.$custName['cust_name'].' </strong>
								</div> 
							';
							}
						}

					$columnName = "*";
					$tableName = "customer";
					$queryResult = $coreModel->selectData($columnName, $tableName);
					foreach($queryResult AS $eachRow)
					{
					if ($eachRow['status'] == 'Active') {
						$blcBtn = '<i class="fa fa-ban"></i>';
						$userId = 'blc';
						$class = 'btn-warning';
						$title = 'Block';
					}else{
						$blcBtn = '<i class="fa fa-check"></i>';
						$userId = 'unblc';
						$class = 'btn-success';
						$title = 'Active';
					}
					echo '
						<tr class="gradeX">
							<td>'.$eachRow['customer_id'].'</td>
							<td>'.$eachRow['cust_name'].'</td>
							<td>'.$eachRow['email'].'</td>
							<td>'.$eachRow['phone'].'</td>
							<td>'.$eachRow['status'].'</td>
							<td>'.$eachRow['date_added'].'</td>
							<td><a title="'.$title.'" class="btn-xs btn '.$class.'" href="?'.$userId.'='.$eachRow['customer_id'].'">'.$blcBtn.'</a>
								<a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['customer_id'].'"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>';
					}				
					?>
        
						</tbody>
						<tfoot>
							<tr>
								<th>#ID</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Status</th>
								<th>Sign Date</th>
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

<script>
    function conf() {
       
        if(confirm("Do you want to delete this Customer?") == false){
                return false;
            }
        }
</script>


<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>