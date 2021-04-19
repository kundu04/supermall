<?php include("config.php") ?>
<?php

// delete product main image
if (isset($_REQUEST['term']))
{
   
 $newA = array();
 $word = $_REQUEST['term'];

 $getCatid = $myModel->customQuery("SELECT * FROM product_description WHERE name LIKE '%$word%'");

  foreach ($getCatid as $key => $value) {

  	$pName[] = array('value'=>strip_tags(html_entity_decode($value['name'])), 'id'=>$value['product_id']);
  }

  echo json_encode($pName);
}

?>