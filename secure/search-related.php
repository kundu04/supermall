<?php include("fw-config.php") ?>

<?php

// Auto Search for Related Product selection
if (isset($_REQUEST['term']))
{
    $newA = array();
	$pName = $_REQUEST['term'];

	$getRelatedId = $myModel->customQuery("SELECT product_id FROM product_description WHERE name LIKE '%$pName%'");
	
	foreach ($getRelatedId as $key => $value) {
  	$newA[] = $value['product_id'];
	}
	
	$productList = $myModel->customQuery("SELECT * FROM product_description");
	
	
	if(count($newA)){
		foreach($productList as $value){ 
  	          if(in_array($value['product_id'], $newA)){
              $productName[] = array('value'=>strip_tags(html_entity_decode($value['name'])), 'id'=>$value['product_id']); 
          }
  }
}

	echo json_encode($productName);
}

?>