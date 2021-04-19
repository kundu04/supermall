<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Sliders
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Sliders</a>
        </li>
        <li class="active"> List Sliders </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
	<!--success notification - START-->
		<?php 
		if (isset($_GET['blc']))
			{
			$tableName = "slider";
			$columnName["0"] = "name";
			$columnName["1"] = "status";
			$whereValue["slider_id"] = $_GET['blc'];
			$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
			foreach ($queryResult AS $sliderblc);
	
			$columnValue["status"] = 'Inactive';
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			echo '
				<div class="alert alert-success alert-block fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
						<i class="fa fa-times"></i></button>
					You have successfully Blocked the slider named: <strong>'.$sliderblc['name'].' </strong>
				</div> 
				';     
			}

		if (isset($_GET['unblc']))
			{
			$tableName = "slider";
			$columnName["0"] = "name";
			$columnName["1"] = "status";
			$whereValue["slider_id"] = $_GET['unblc'];
			$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
			foreach ($queryResult AS $sliderUblc);

			$columnValue["status"] = 'Active';
			$queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
			echo '
				<div class="alert alert-success alert-block fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
						<i class="fa fa-times"></i></button>
					You have successfully Actived the slider named: <strong>'.$sliderUblc['name'].' </strong>
				</div> 
				';     
			}

		if (isset($_GET['del']))
			{
			$tableName = "slider";
			$columnName["0"] = "name";
			$whereValue["slider_id"] = $_GET['del'];
			$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
			foreach ($queryResult AS $sliderName);
			$queryResult = $coreModel->deleteData($tableName, $whereValue);
				if($queryResult > 0)
				{
				echo '
					<div class="alert alert-success alert-block fade in">
						<button type="button" class="close close-sm" data-dismiss="alert">
							<i class="fa fa-times"></i></button>You have successfully Deleted the Slider named: <strong>'.$sliderName['name'].' </strong>
					</div> 
					';
				}
			}
		?>
       <!--success notification -  END-->     
			<section class="panel">
				<header class="panel-heading">
					List Sliders
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
							<th>Slider Name</th>
							<th>Title</th>
							<th>Sub-Title</th>
							<th>Status</th>
							<th>Sort Order</th>
							<th>Image</th>
							<th>Link</th>
							<th style="width:60px">Action</th>
						</tr>
					</thead>
					<tbody>
					
					<?php
					$columnName = "*";
					$tableName = "slider";
					$queryResult = $coreModel->selectData($columnName, $tableName);
					foreach($queryResult AS $eachRow)
					{
						if ($eachRow['status'] == 'Active') {
							$blcBtn = '<i class="fa fa-ban"></i>';
							$sliderId = 'blc';
							$class = 'btn-warning';
							$title = 'Block';
						}else{
							$blcBtn = '<i class="fa fa-check"></i>';
							$sliderId = 'unblc';
							$class = 'btn-success';
							$title = 'Active';
						}
					echo '
					<tr class="gradeX">
						<td>'.$eachRow['slider_id'].'</td>
						<td>'.$eachRow['name'].'</td>
						<td>'.$eachRow['title'].'</td>
						<td>'.$eachRow['sub_title'].'</td>
						<td>'.$eachRow['status'].'</td>
						<td>'.$eachRow['sort_order'].'</td>
						<td class="col-md-1"><img class="img-responsive" src=' . $eachRow['image'] .'></td>
						<td>'.$eachRow['link'].'</td>
						<td><a title="'.$title.'" class="btn btn-xs '.$class.'" href="?'.$sliderId.'='.$eachRow['slider_id'].'">'.$blcBtn.'</a>
						<a title="Edit" class="btn btn-info btn-xs" href="slider-edit.php?sid='.$eachRow['slider_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                        <a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['slider_id'].'"><i class="fa fa-trash-o"></i></a></td>
					</tr>';
					}				
					?>
    		
            
					</tbody>
					<tfoot>
						<tr>
							<th>#ID</th>
							<th>Slider Name</th>
							<th>Title</th>
							<th>Sub-Title</th>
							<th>Status</th>
							<th>Sort Order</th>
							<th>Image</th>
							<th>Link</th>
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
       
        if(confirm("Do you want to delete this Slider?") == false){
                return false;
            }
        }
</script>

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>