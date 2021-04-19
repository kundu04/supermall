<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Banners
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Banners</a>
        </li>
        <li class="active"> List Banners </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
				<header class="panel-heading">
					List Banners
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
							<th>Banner Name</th>
							<th>Link</th>
							<th>Status</th>
							<th>Position</th>
							<th>Sort Order</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					if (isset($_GET['blc']))
					{
					$tableName = "banner";
					$columnName["0"] = "name";
					$columnName["1"] = "status";
					$whereValue["banner_id"] = $_GET['blc'];
					$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
					foreach ($queryResult AS $bannerblc);

					$columnValue["status"] = 'Inactive';
					$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
					echo '
						<div class="alert alert-success alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i></button>
							You have successfully Blocked the banner named: <strong>'.$bannerblc['name'].' </strong>
						</div> 
						';     
					}

					if (isset($_GET['unblc']))
					{
					$tableName = "banner";
					$columnName["0"] = "name";
					$columnName["1"] = "status";
					$whereValue["banner_id"] = $_GET['unblc'];
					$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
					foreach ($queryResult AS $bannerUblc);

					$columnValue["status"] = 'Active';
					$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
					echo '
						<div class="alert alert-success alert-block fade in">
							<button type="button" class="close close-sm" data-dismiss="alert">
								<i class="fa fa-times"></i></button>
							You have successfully Actived the banner named: <strong>'.$bannerUblc['name'].' </strong>
						</div> 
						';     
					}

					if (isset($_GET['del']))
					{
					$tableName = "banner";
					$columnName["0"] = "name";
					$whereValue["banner_id"] = $_GET['del'];
					$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
					foreach ($queryResult AS $bannerName);
					$queryResult = $coreModel->deleteData($tableName, $whereValue);
						if($queryResult > 0)
						{
						echo '
							<div class="alert alert-success alert-block fade in">
								<button type="button" class="close close-sm" data-dismiss="alert">
									<i class="fa fa-times"></i></button>You have successfully Deleted the banner named: <strong>'.$bannerName['name'].' </strong>
							</div> 
							';
						}
					}

					$columnName = "*";
					$tableName = "banner";
					$queryResult = $coreModel->selectData($columnName, $tableName);
					foreach($queryResult AS $eachRow)
					{
						if ($eachRow['status'] == 'Active') {
							$blcBtn = '<i class="fa fa-ban"></i>';
							$bannerId = 'blc';
							$class = 'btn-warning';
							$title = 'Block';
						}else{
							$blcBtn = '<i class="fa fa-check"></i>';
							$bannerId = 'unblc';
							$class = 'btn-success';
							$title = 'Active';
						}
					echo '
					<tr class="gradeX">
						<td>'.$eachRow['banner_id'].'</td>
						<td>'.$eachRow['name'].'</td>
						<td>'.$eachRow['link'].'</td>
						<td>'.$eachRow['status'].'</td>
						<td>'.$eachRow['position'].'</td>
						<td>'.$eachRow['sort_order'].'</td>
						<td class="col-md-1"><img class="img-responsive" src=' . $eachRow['image'] .'></td>
						<td><a title="'.$title.'" class="btn btn-xs '.$class.'" href="?'.$bannerId.'='.$eachRow['banner_id'].'">'.$blcBtn.'</a>
						<a title="Edit" class="btn btn-info btn-xs" href="banner-edit.php?bid='.$eachRow['banner_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                        <a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['banner_id'].'"><i class="fa fa-trash-o"></i></a></td>
					</tr>';
					}				
					?>
    		
            
					</tbody>
					<tfoot>
						<tr>
							<th>#ID</th>
							<th>Banner Name</th>
							<th>Link</th>
							<th>Status</th>
							<th>Position</th>
							<th>Sort Order</th>
							<th>Image</th>
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
       
        if(confirm("Do you want to delete this Banner?") == false){
                return false;
            }
        }
</script>

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>