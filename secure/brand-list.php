<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Product Brands
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Product Brands</a>
        </li>
        <li class="active"> List Brands </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
            <header class="panel-heading">
                Brands
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
                    <th>Brand Name</th>
    				<th>Category Name</th>
                    <th>Position</th>
    				<th>Logo</th>
                    <th>Action</th>
    			</tr>
            </thead>
            <tbody>
    		
    		<?php 
     
            if (isset($_GET['del']))
            {
                $tableName = "category";
                $columnName["0"] = "name";
                $whereValue["category_id"] = $_GET['del'];
                $queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
                foreach ($queryResult AS $catName);
                $queryResult = $coreModel->deleteData($tableName, $whereValue);
                if($queryResult > 0)
                {
                echo '
                    <div class="alert alert-success alert-block fade in">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                        You have successfully Deleted the category named: <strong>'.$catName['name'].' </strong>
                    </div> 
                ';
                }
            }


            $queryResult = $myModel->get_brnad_list();

			foreach($queryResult AS $eachRow)
			{ if ($eachRow['top'] == 1) {
                $position = 'Top Menu';
            }else{
                $position = 'Sub Menu';
            }
			echo 
            '<tr class="gradeX">
				<td>'.$eachRow['manufacturer_id'].'</td>
                <td>'.$eachRow['brand_name'].'</td>
				<td>'.$eachRow['cat_name'].'</td>
				<td>'.$position.'</td>
                <td class="col-md-1"><img class="img-responsive" src='.$eachRow['logo'].'></td>
				<td><a title="Edit" class="btn btn-info btn-xs" href="brand-edit.php?bid='.$eachRow['manufacturer_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                    <a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['manufacturer_id'].'"><i class="fa fa-trash-o"></i></a>
                </td>
			</tr>';
			}				
    		?>
            
            </tbody>
            <tfoot>
            <tr>
    			<th>#ID</th>
                <th>Brand Name</th>
                <th>Category Name</th>
                <th>Position</th>
                <th>Logo</th>
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

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>