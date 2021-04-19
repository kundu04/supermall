<?php include("fw-config.php") ?>
<?php

// Auto Search on Category selection box
if (isset($_REQUEST['term']))
{
    $newA = array();
 $word = $_REQUEST['term'];

 $getCatid = $myModel->customQuery("SELECT category_id FROM category WHERE cat_name LIKE '%$word%'");

  foreach ($getCatid as $key => $value) {
  	$newA[] = $value['category_id'];
  }
function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '', $panetName='') 
{
	$term = $_REQUEST['term'];
	if (!is_array($category_tree_array))
	$category_tree_array = array();
    global $myModel;
	
	$data = $myModel->customQuery("SELECT * FROM category WHERE parent_id='$parent'");

	foreach($data as $value) {
		$category_tree_array[] = array("category_id" => $value['category_id'], "cat_name" => $panetName.$spacing . $value['cat_name']);
		$category_tree_array = categoryParentChildTree($value['category_id'], $spacing . '-&nbsp;', $category_tree_array, $panetName.$spacing . ''.$value['cat_name']);
	}
	return $category_tree_array;
}

$categoryList = categoryParentChildTree(); 
if(count($newA)){
  foreach($categoryList as $value){ 
  	          if(in_array($value['category_id'], $newA)){
              $catName[] = array('value'=>strip_tags(html_entity_decode($value['cat_name'])), 'id'=>$value['category_id']); 
          }
  }
}

  echo json_encode($catName);
}

?>