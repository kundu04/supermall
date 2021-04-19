<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php"); 

function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '', $panetName='') 
{
    if (!is_array($category_tree_array))
    $category_tree_array = array();
    global $coreModel;
    $data = $coreModel->selectData('*', 'category', array('parent_id'=>$parent));

    foreach($data as $value) {
        $category_tree_array[] = array("category_id" => $value['category_id'], "cat_name" => $panetName.$spacing . $value['cat_name'], "status" => $value['status'], "logo" => $value['logo'], "banner" => $value['banner'], "top" => $value['top'],"sort_order" => $value['sort_order']);
        $category_tree_array = categoryParentChildTree($value['category_id'], $spacing . '-&nbsp;', $category_tree_array, $panetName.$spacing . ''.$value['cat_name']);
    }
    return $category_tree_array;
}

?>

<!-- page heading start-->
<div class="page-heading">
    <h3>
        List Categories
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Category</a>
        </li>
        <li class="active"> List Categories </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
            <header class="panel-heading">
                Categories
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
    				<th>SL No</th>
    				<th>Name</th>
                    <th>Status</th>
    				<th>Position</th>
    				<th>Sort Order</th>
                    <th>Logo</th>
    				<th>Banner</th>
                    <th>Action</th>
    			</tr>
            </thead>
            <tbody>
    		
    		<?php 
     
            if (isset($_GET['del']))
            {
                $tableName = "category";
                $columnName["0"] = "cat_name";
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
                        You have successfully Deleted the category named: <strong>'.$catName['cat_name'].' </strong>
                    </div> 
                ';
                }
            }

            $categoryList = categoryParentChildTree(); 
			foreach($categoryList AS $key=>$eachRow)
			
			{ if ($eachRow['top'] == 1) {
                $position = 'Top Menu';
            }else{
                $position = 'Sub Menu';
            }
            $key = $key+1;
			
			echo '<tr class="gradeX">
					<td>'.$key.'</td>
					<td>'.$eachRow['cat_name'].'</td>
                    <td>'.$eachRow['status'].'</td>
					<td>'.$position.'</td>
					<td>'.$eachRow['sort_order'].'</td>
                    <td class="col-md-1"><img class="img-responsive" src=' . $eachRow['logo'] .'></td>
                    <td class="col-md-1"><img class="img-responsive" src=' . $eachRow['banner'] .'></td>
					<td><a title="Edit" class="btn btn-info btn-xs" href="category-edit.php?cid='.$eachRow['category_id'].'"><i class="fa fa-pencil-square-o"></i></a>
                        <a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['category_id'].'"><i class="fa fa-trash-o"></i></a>
                    </td>
				</tr>';
			}				
    		?>
            
            </tbody>
            <tfoot>
            <tr>
    			<th>SL No</th>
    			<th>Name</th>
    			<th>Status</th>
                <th>Position</th>
				<th>Sort Order</th>
    			<th>Logo</th>
                <th>Banner</th>
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
$(document).ready(function(){
    $(".cat_edit").click(function(){
        var category_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "ajax_loader.php",
            data:{get_category_id:category_id}
        }).done(function(data){
           $("#cat_edit").html(data);
        });
    });
});

function conf() {
   
    if(confirm("Do you want to delete this Category?") == false){
        return false;
    }
}
</script>

<?php $coreView->call("content-footer"); ?>
<?php $coreView->call("footer"); ?>
<?php $coreView->call("data-table"); ?>