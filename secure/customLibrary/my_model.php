<?php
/*
	Model Name: My_model
	Developed By: Nova Framework Developer
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

/* CORE MODEL */

class My_model
{
	private $conn2;
	
	// Database 1 - Variable //
	private $host1 = HOSTNAME_1;
	private $username1 = USERNAME_1;
	private $password1 = PASSWORD_1;
	private $database1 = DATABASE_1;
	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION ---------- ---------- ---------- */
	
	public function __construct()
	{
		$this->conn2 = new PDO('mysql:host='.$this->host1.';dbname='.$this->database1.';charset=utf8', $this->username1, $this->password1);
		$this->conn2->setAttribute(PDO::ATTR_ERRMODE, "PDO::ERRMODE_EXCEPTION"); // PDO::ERRMODE_WARNING //
		$this->conn2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	
	/* ---------- ---------- ---------- CUSTOM FUNCTION ---------- ---------- ---------- */
	
	
	public function customQuery($query)
	{
		$sql = $this->conn2->query($query);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}
	
	public function insertQuery($query){
		
		$sql = $this->conn2->query($query);
        $lastInsertId = $this->conn2->lastInsertId();
		return $lastInsertId;
	}

	public function get_brnad_list()
	{
		$sql = "
			SELECT manufacturer.*, category.cat_name, category.top
			FROM manufacturer
			INNER JOIN category ON manufacturer.category_id = category.category_id
		";
		
		$sql = $this->conn2->query($sql);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}
	
	public function get_pro_proDes ()
	{
		$sql = "
			SELECT product.*, product_description.*
			FROM product 
			LEFT JOIN product_description
				ON product.product_id = product_description.product_id
			ORDER BY product.product_id DESC
			
			";
		
		$sql = $this->conn2->query($sql);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}

	public function get_cat_proToCat ()
	{
		$productId = $_GET['id'];
		$sql = "
			SELECT product_to_category.*, category.* 
			FROM product_to_category 
			LEFT JOIN category 
				ON product_to_category.category_id = category.category_id
			WHERE product_to_category.product_id = '".$productId."'
			
			";
		
		$sql = $this->conn2->query($sql);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}

	public function get_proColor ()
	{
		$productId = $_GET['id'];
		$sql = "
			SELECT product_color.*, color.* 
			FROM product_color 
			LEFT JOIN color 
				ON product_color.color_id = color.color_id
			WHERE product_color.product_id = '".$productId."'
			
			";
		
		$sql = $this->conn2->query($sql);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}

	public function get_proSize ()
	{
		$productId = $_GET['id'];
		$sql = "
			SELECT product_size.*, size.* 
			FROM product_size 
			LEFT JOIN size 
				ON product_size.size_id = size.size_id
			WHERE product_size.product_id = '".$productId."'
			
			";
		
		$sql = $this->conn2->query($sql);
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		return @$data;
	}

}
?>