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
            <th>Group Name</th>
            <th>Action</th>
			</tr>
        </thead>
        <tbody>
		<?php 

        if (isset($_GET['del']))
        {
            $tableName = "admin_group";
            $columnName["0"] = "name";
            $whereValue["admin_group_id"] = $_GET['del'];
            $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
            foreach ($queryResult AS $adminName);
            $queryResult = $coreModel->deleteData($tableName, $whereValue);
            if($queryResult > 0)
            {
            echo '
                <div class="alert alert-success alert-block fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i></button>
                   You have successfully Deleted the admin group: <strong>'.$adminName['name'].' </strong>
                </div> 
            ';
            }
        }

        $columnName = "*";
        $tableName = "admin_group";
        $queryResult = $coreModel->selectData($columnName, $tableName);
		foreach($queryResult AS $eachRow)
    	{
    		echo '
            <tr class="gradeX">
				<td>'.$eachRow['admin_group_id'].'</td>
				<td>'.$eachRow['name'].'</td>
                <td><a title="Edit" class="btn btn-info btn-xs" href="admin-group-edit.php?id='.$eachRow['admin_group_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                    <a onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['admin_group_id'].'"><i class="fa fa-trash-o"></i></a>
                </td>
			</tr>';
    	}				
		?>
        </tbody>
        <tfoot>
        <tr>
            <th>#ID</th>
            <th>Group Name</th>
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
       
        if(confirm("Do you want to delete this Admin Group?") == false){
                return false;
            }
        }
</script>


<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); ?>