<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                List Admins
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admins</a>
                </li>
                <li class="active"> List Admins </li>
            </ul>
        </div>
        <!-- page heading end-->
		
        <!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Admins
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
				<th>Name</th>
				<th>Eemail</th>
				<th>Type</th>
                <th>Status</th>
                <th>Action</th>
			</tr>
        </thead>
        <tbody>
		<?php 

        if (isset($_GET['blc']))
            {
                $tableName = "admin";
                $columnName["0"] = "name";
                $columnName["1"] = "status";
                $whereValue["admin_id"] = $_GET['blc'];
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $adminblc);

                $columnValue["status"] = 'Inactive';
                $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
                echo '
                    <div class="alert alert-success alert-block fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                        You have successfully Blocked the admin named: <strong>'.$adminblc['name'].' </strong>
                    </div> 
                ';     
            }

        if (isset($_GET['unblc']))
            {
                $tableName = "admin";
                $columnName["0"] = "name";
                $columnName["1"] = "status";
                $whereValue["admin_id"] = $_GET['unblc'];
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $adminUblc);

                $columnValue["status"] = 'Active';
                $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
                echo '
                    <div class="alert alert-success alert-block fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                        You have successfully Actived the admin named: <strong>'.$adminUblc['name'].' </strong>
                    </div> 
                ';     
            }

        if (isset($_GET['del']))
            {
                $tableName = "admin";
                $columnName["0"] = "name";
                $whereValue["admin_id"] = $_GET['del'];
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $adminName);
                $queryResult = $coreModel->deleteData($tableName, $whereValue);
                if($queryResult > 0)
                {
                echo '
                    <div class="alert alert-success alert-block fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                       You have successfully Deleted the admin named: <strong>'.$adminName['name'].' </strong>
                    </div> 
                ';
                }
            }

        $columnName = "*";
        $tableName = "admin";
        $queryResult = $coreModel->selectData($columnName, $tableName);
		foreach($queryResult AS $eachRow)
    		{
                if ($eachRow['status'] == 'Active') {
                    $blcBtn = '<i class="fa fa-ban"></i>';
                    $adminId = 'blc';
                    $class = 'btn-warning';
                    $title = 'Block';
                }else{
                    $blcBtn = '<i class="fa fa-check"></i>';
                    $adminId = 'unblc';
                    $class = 'btn-success';
                    $title = 'Active';
                }
    		echo '
                <tr class="gradeX">
    				<td>'.$eachRow['admin_id'].'</td>
    				<td>'.$eachRow['name'].'</td>
    				<td>'.$eachRow['email'].'</td>
                    <td>'.$eachRow['admin_type'].'</td>
    				<td>'.$eachRow['status'].'</td>
                    <td><a title="'.$title.'" class="btn btn-xs '.$class.'" href="?'.$adminId.'='.$eachRow['admin_id'].'">'.$blcBtn.'</a>
                        <a onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['admin_id'].'"><i class="fa fa-trash-o"></i></a>
                    </td>
    			</tr>';
    		}				
		?>
        </tbody>
        <tfoot>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Eemail</th>
            <th>Type</th>
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
<script>
    function conf() {
       
        if(confirm("Do you want to delete this Admin?") == false){
                return false;
            }
        }
</script>


<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>