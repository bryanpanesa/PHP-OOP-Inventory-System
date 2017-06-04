<?php

require "db.php";

class DataOperation extends Database
{
	public function insert_product($table, $fields)
	{
		//"INSERT INTO products ( , ,) VALUES ('','')";
		$sql = "";
		$sql .= "INSERT INTO ".$table;
		$sql .= " (".implode(",", array_keys($fields)).") VALUES ";
		$sql .= "('".implode("','", array_values($fields))."')";
		
		$query = mysqli_query($this->con, $sql);
		if($query)
		{
			return true;
		}
	}
	public function fetch_products($table)
	{
		$sql = "SELECT * FROM ".$table;
		$array = array();
		$query = mysqli_query($this->con, $sql);

		while($row = mysqli_fetch_assoc($query))
		{
			$array[] = $row;
		}
		return $array;
	}
	public function select_products($table, $where) 
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			#// id = '5' AND p_name = 'something'
			$condition .= $key."='".$value. "' AND ";
		}
		$condition = substr($condition, 0, -5); //remove last 5 characters from right-left
		$sql .= "SELECT * FROM ".$table." WHERE ".$condition;
		$query = mysqli_query($this->con,$sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}
	public function update_products($table, $where, $fields) {
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key."='".$value. "' AND ";
		}
		$condition = substr($condition, 0, -5);
		foreach ($fields as $key => $value) {
			// UPDATE products set p_name = '', p_qty = '' WHERE id = '';
			$sql .= $key."='".$value."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;
		
		if(mysqli_query($this->con, $sql))
		{
			return true;
		}
	}
	public function delete_products($table, $where)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key."='".$value. "' AND ";
		}
		$condition = substr($condition, 0, -5); 
		$sql = "DELETE FROM ".$table." WHERE ".$condition;
		
		if(mysqli_query($this->con, $sql))
		{
			return true;
		}
	}
	public function count_products($table) 
	{
		$sql = "";
		$sql .= "SELECT count(*) FROM ".$table;
		$query = mysqli_query($this->con,$sql);
		$count = mysqli_fetch_row($query);
		return $count;
	}
}

$obj = new DataOperation;

if(isset($_POST['product_submit'])) 
{	
	$myArray = array(						// LEFT part are the fields, RIGHT is input
		"p_name" => $_POST["product_name"],
		"p_qty" => $_POST["product_qty"]
		);
	if($obj->insert_product("products",$myArray))
	{
		$prod = $_POST["product_name"];
		header("location: index.php?$prod-inserted-successfully");
	}
	
}

if(isset($_POST['product_edit']))
{
	$id = $_POST['id'];
	$where = array("id"=> $id);
	$myArray = array(						// LEFT part are the fields, RIGHT is input
		"p_name" => $_POST["product_name"],
		"p_qty" => $_POST["product_qty"]
		);
	if($obj->update_products("products", $where, $myArray))
	{
		header("location: index.php?$prod-updated-successfully");
	}
}

if(isset($_GET['delete']))
{
	$id = $_GET['id'] ?? null;
	$where = array("id"=>$id);
	if($obj->delete_products("products", $where))
	{
		header("location: index.php?$prod-deleted-successfully");
	}
}
?>