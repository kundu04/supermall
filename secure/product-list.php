<?php include("fw-config.php") ?>
<?php $coreView->call("header");  ?>
<?php $coreView->call("sidebar");  ?>
<?php include("includeFile/content-header.php");  ?>

<!-- page heading start-->
        <div class="page-heading">
            <h3>
                List Products
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="product-list.php">Product</a>
                </li>
                <li class="active"> List Products </li>
            </ul>
        </div>
    <!-- page heading end-->
		
    <!--body wrapper start-->
    <div class="wrapper">
      <div class="row">
        <div class="col-sm-12">
		 <?php if(isset($_SESSION['mgs'])){ echo $_SESSION['mgs']; } ?>
	<!--success notification-->
			<?php
			
			if (isset($_GET['del']))
			{
				$columnName['0'] = "name";
				$tableName = "product_description";
				$whereValue["product_id"] = $_GET['del'];
				$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
				foreach ($queryResult AS $eachRow);
				
				$tableName = "product";
				$whereValue["product_id"] = $_GET['del'];
				$queryResult = $coreModel->deleteData($tableName, $whereValue);
					$coreModel->deleteData('product_color', @$whereValue);
					$coreModel->deleteData('product_description', @$whereValue);
					$coreModel->deleteData('product_discount', @$whereValue);
					$coreModel->deleteData('product_image', @$whereValue);
					$coreModel->deleteData('product_size', @$whereValue);
					$coreModel->deleteData('product_to_category', @$whereValue);
					$coreModel->deleteData('product_releted', @$whereValue);
					
				echo '
					<div class="alert alert-success alert-block fade in">
						<button type="button" class="close close-sm" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
						<h4>
							<i class="icon-ok-sign"></i>
							Success!
						</h4>
			<p>You have Deleted Product named <strong>'.$eachRow["name"].' </strong>.</p>
					</div> 
				';
			}
			?>
			
	<!--success notification-->
		
		
        <section class="panel">
			<header class="panel-heading">
				List Products 
				<span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					<a href="javascript:;" class="fa fa-times"></a>
				 </span>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped" id="datatable">
					<thead>
						<tr>
							<th>SL No</th>
							<th>Product Name</th>
							<th>SKU</th>
							<th>Model</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Image</th>
							<th>Viewed</th>
							<th>Type</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</tr>
					</thead>
					<tbody>
					
					<?php 
					$queryResult = $myModel->get_pro_proDes();
					foreach($queryResult AS $key => $eachRow){
					echo '
					<tr class="gradeX">
						<td>'.($key+1).'</td>
						<td>'.$eachRow['name'].'</td>
						<td>'.$eachRow['sku'].'</td>
						<td>'.$eachRow['model'].'</td>
						<td>'.$eachRow['quantity'].'</td>
						<td>'.$eachRow['price'].'</td>
						<td class="col-md-1"><img class="img-responsive" src='.$eachRow['main_image'].'></td>
						<td>'.$eachRow['viewed'].'</td>
						<td>'.$eachRow['type'].'</td>
						<td>'.$eachRow['status'].'</td>
						<td><a class="btn btn-success btn-xs" href="product-edit.php?id='.$eachRow['product_id'].'" title="Edit"><i class="fa fa-pencil"></i></a>
							<a title="Delete" onclick="return conf()" class="btn btn-danger btn-xs" href="?del='.$eachRow['product_id'].'"><i class="fa fa-trash-o"></i></a>
						</td>
					</tr>';
					}				
					?>
					
					</tbody>
					<tfoot>
						<tr>
							<th>SL No</th>
							<th>Product Name</th>
							<th>SKU</th>
							<th>Model</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Image</th>
							<th>Viewed</th>
							<th>Type</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
        </section>
       </div>
      </div>
    </div>
 <!--body wrapper end-->
		
<script>
    function conf() {
       
        if(confirm("Do you want to delete this Product?") == false){
                return false;
            }
        }
</script>
		
<?php $coreView->call("content-footer");  ?>
<?php $coreView->call("footer");  ?>
<?php $coreView->call("data-table"); 
	unset($_SESSION['mgs']); 
?>