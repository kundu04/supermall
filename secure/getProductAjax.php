<?php 

include("fw-config.php");

 $searchTerm = $_GET['term'];
 
 
 
$category = $myModel->customQuery("SELECT * FROM category WHERE cat_name LIKE '%".$searchTerm."%' ORDER BY cat_name ASC");

foreach($category as $value){
	
	$data[] = $value['cat_name'];
	
}

 echo json_encode($data);

 ?>
