<?php
/*
	Model Name: Model
	Developed By: Nova Framework Developer
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

/* CORE MODEL */

class Model
{
	/* ---------- ---------- ---------- VARIABLE DECLARATION // Config ---------- ---------- ---------- */
	
	private $conn;
	
	// Database 1 - Variable //
	private $host1 = HOSTNAME_1;
	private $username1 = USERNAME_1;
	private $password1 = PASSWORD_1;
	private $database1 = DATABASE_1;
	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION ---------- ---------- ---------- */
	
	public function __construct()
	{
		$this->conn = new PDO('mysql:host='.$this->host1.';dbname='.$this->database1.';charset=utf8', $this->username1, $this->password1);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, "PDO::ERRMODE_EXCEPTION"); // PDO::ERRMODE_WARNING //
		$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	
	// ---------- ---------- ---------- INSERT FUNCTION SET ---------- ---------- ---------- //

	public function insertData($tableName, $columnValue)
	{
		try
		{
			$sql1 = "INSERT INTO `$tableName` SET ";
			
			foreach($columnValue AS $ca1Column => $ca1Value)
			{
				$ca1ColumnUpper = strtoupper($ca1Column);
				@$sql2 .= "`$ca1Column`=:$ca1ColumnUpper, ";
			}
			$sql2 = rtrim(@$sql2, ", ");
			
			$preSQL = $sql1 . $sql2; //
			$query = $this->conn->prepare($preSQL);
			
			foreach($columnValue AS $ca2Column => $ca2Value)
			{
				$ca2ColumnUpper = strtoupper($ca2Column);

				$postSQL[$ca2ColumnUpper] = $ca2Value;
			}

			$query->execute($postSQL);
			$dataAdded = $query->rowCount();
			$lastInsertId = $this->conn->lastInsertId();
			
			return array("no_of_row_inserted"=>$dataAdded, "last_insert_id"=>$lastInsertId);
		}
		catch(Exception $e) 
		{
			return 0;
		}
	}
	
	// ---------- ---------- ---------- UPDATE FUNCTION SET ---------- ---------- ---------- //

	public function updateData($tableName, $columnValue, $whereValue = 0)
	{
		try
		{
			$sql1 = "UPDATE `$tableName` SET ";
			
			foreach($columnValue AS $ca1Column => $ca1Value)
			{
				$ca1ColumnUpper = strtoupper($ca1Column);
				@$sql2 .= "`$ca1Column`=:$ca1ColumnUpper, ";
			}
			$sql2 = rtrim(@$sql2, ", ");
			
			if($whereValue == 0)
			{
				$preSQL = $sql1 . $sql2;
			}
			else
			{
				$sql3 = " WHERE ";
				foreach($whereValue AS $wa1Column => $wa1Value)
				{
					$wa1ColumnUpper = strtoupper($wa1Column);
					@$sql4 .= "`$wa1Column`=:$wa1ColumnUpper AND ";
				}
				$sql4 = substr(@$sql4, 0, -4); // $sql4 = rtrim(@$sql4, "AND "); //
				
				$preSQL = $sql1 . $sql2 . $sql3 . $sql4;
			}
			
			$query = $this->conn->prepare($preSQL);
			
			if($whereValue == 0)
			{
				foreach($columnValue AS $ca2Column => $ca2Value)
				{
					$ca2ColumnUpper = strtoupper($ca2Column);

					$postSQL[$ca2ColumnUpper] = $ca2Value;
				}
			}
			else
			{
				foreach($columnValue AS $ca2Column => $ca2Value)
				{
					$ca2ColumnUpper = strtoupper($ca2Column);

					$postSQL[$ca2ColumnUpper] = $ca2Value;
				}
				
				foreach($whereValue AS $wa2Column => $wa2Value)
				{
					$wa2WhereUpper = strtoupper($wa2Column);

					$postSQL[$wa2WhereUpper] = $wa2Value;
				}
			}

			$query->execute($postSQL);
			$dataUpdated = $query->rowCount();
			
			return $dataUpdated;
		}
		catch(Exception $e) 
		{
			return 0;
		}
	}
	
	// ---------- ---------- ---------- DELETE FUNCTION SET ---------- ---------- ---------- //

	public function deleteData($tableName, $whereValue)
	{
		try
		{
			$sql1 = "DELETE FROM `$tableName` WHERE ";
			
			foreach($whereValue AS $wa1Column => $wa1Value)
			{
				$wa1ColumnUpper = strtoupper($wa1Column);
				@$sql2 .= "`$wa1Column`=:$wa1ColumnUpper AND ";
			}
			$sql2 = trim($sql2); $sql2 = rtrim($sql2, "AND"); $sql2 = trim($sql2);
			
			$preSQL = $sql1 . $sql2;
			
			$query = $this->conn->prepare($preSQL);
			
			foreach($whereValue AS $wa2Column => $wa2Value)
			{
				$wa2WhereUpper = strtoupper($wa2Column);

				$postSQL[$wa2WhereUpper] = $wa2Value;
			}
			
			$query->execute($postSQL);
			$dataDeleted = $query->rowCount();
			
			return $dataDeleted;
		}
		catch(Exception $e) 
		{
			return 0;
		}
	}
	
	// ---------- ---------- ---------- SELECT FUNCTION SET ---------- ---------- ---------- //

	public function selectData($columnName, $tableName, $whereValue = 0, $formatBy = 0, $paginate = 0)
	{
		
		try
		{
			// -- SELECT FROM TABLE -- //
			if($columnName == "*")
			{
				$sql1 = "SELECT ";
				$sql2 = "*";
			}
			else
			{
				$sql1 = "SELECT ";
				foreach($columnName AS $ca1Column => $ca1Value)
				{
					$ca1ColumnUpper = strtoupper($ca1Value);
					@$sql2 .= "`$ca1Value`, ";
				}
				$sql2 = rtrim(@$sql2, ", ");
			}
			$sql3 = " FROM `$tableName`";
			// -- SELECT FROM TABLE -- //
			
			// -- FORMAT -- //
			if(@$formatBy['group'])
				$sql6 = " GROUP BY `" . $formatBy['group'] . "`";
			else
				$sql6 = "";
			
			if(@$formatBy['order_asc'])
				$sql7 = " ORDER BY `" . $formatBy['order_asc'] . "` ASC";
			else if(@$formatBy['order_desc'])
				$sql7 = " ORDER BY `" . $formatBy['order_desc'] . "` DESC";
			else
				$sql7 = "";
			// -- FORMAT -- //
			
			// -- WHERE -- //
			if($whereValue != 0)
			{
				$sql4 = " WHERE ";
			
				foreach($whereValue AS $wa1Column => $wa1Value)
				{
					$wa1ColumnUpper = strtoupper($wa1Column);
					@$sql5 .= "`$wa1Column`=:$wa1ColumnUpper AND ";
				}
				$sql5 = trim($sql5); $sql5 = rtrim($sql5, "AND"); $sql5 = trim($sql5); // NIRU //
				
				$preSQL = $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6 . $sql7;
			}
			else
			{
				$preSQL = $sql1 . $sql2 . $sql3 . $sql6 . $sql7;
			}
			// -- WHERE -- //
			
			// -- PAGINATION HANDLER -- //
			if($paginate != 0)
				$preSQL = $preSQL . " LIMIT " . $paginate['point'] . ", " . $paginate['limit'];
			// -- PAGINATION HANDLER -- //
			
			// -- PREPARE -- //
			if($whereValue != 0)
			{
				$query = $this->conn->prepare($preSQL);
				
				foreach($whereValue AS $wa2Column => $wa2Value)
				{
					$wa2WhereUpper = strtoupper($wa2Column);

					$postSQL[$wa2WhereUpper] = $wa2Value;
				}
				
				$query->execute($postSQL);
			}
			else
				$query = $this->conn->query($preSQL);
			// -- PREPARE -- //
			
			  
			  
			$dataSelected = $query->fetchAll(PDO::FETCH_ASSOC);
			
			return $dataSelected;
		}
		catch(Exception $e) 
		{
			
			return 0;
		}
	}
	
	// ---------- ---------- ---------- COUNT FUNCTION SET ---------- ---------- ---------- //

	public function countData($columnName, $tableName, $whereValue = 0, $formatBy = 0, $paginate = 0)
	{
		try
		{
			// -- SELECT FROM TABLE -- //
			if($columnName == "*")
			{
				$sql1 = "SELECT ";
				$sql2 = "COUNT(*)";
			}
			else
			{
				$sql1 = "SELECT ";
				foreach($columnName AS $ca1Column => $ca1Value)
				{
					$ca1ColumnUpper = strtoupper($ca1Value);
					@$sql2 .= "COUNT(`$ca1Value`), ";
				}
				$sql2 = rtrim(@$sql2, ", ");
			}
			$sql3 = " AS TOTAL FROM `$tableName`";
			// -- SELECT FROM TABLE -- //
			
			// -- FORMAT -- //
			if(@$formatBy['group'])
				$sql6 = " GROUP BY `" . $formatBy['group'] . "`";
			else
				$sql6 = "";
			// -- FORMAT -- //
			
			// -- WHERE -- //
			if($whereValue != 0)
			{
				$sql4 = " WHERE ";
			
				foreach($whereValue AS $wa1Column => $wa1Value)
				{
					$wa1ColumnUpper = strtoupper($wa1Column);
					@$sql5 .= "`$wa1Column`=:$wa1ColumnUpper AND ";
				}
				$sql5 = trim($sql5); $sql5 = rtrim($sql5, "AND"); $sql5 = trim($sql5); // NIRU //
				
				$preSQL = $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6;
			}
			else
			{
				$preSQL = $sql1 . $sql2 . $sql3 . $sql6;
			}
			// -- WHERE -- //
			
			// -- PAGINATION HANDLER -- //
			if($paginate != 0)
				$preSQL = $preSQL . " LIMIT " . $paginate['point'] . ", " . $paginate['limit'];
			// -- PAGINATION HANDLER -- //
			
			// -- PREPARE -- //
			if($whereValue != 0)
			{
				$query = $this->conn->prepare($preSQL);
				
				foreach($whereValue AS $wa2Column => $wa2Value)
				{
					$wa2WhereUpper = strtoupper($wa2Column);

					$postSQL[$wa2WhereUpper] = $wa2Value;
				}
				
				$query->execute($postSQL);
			}
			else
				$query = $this->conn->query($preSQL);
			// -- PREPARE -- //
			
			$dataSelected = $query->fetchAll(PDO::FETCH_ASSOC);
			
			return $dataSelected[0]['TOTAL'];
		}
		catch(Exception $e) 
		{
			return 0;
		}
	}
}
?>