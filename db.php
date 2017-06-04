<?php

class Database 
{
	public $con;
	public function __construct()
	{
		$this->con = mysqli_connect("localhost","root","","inventory_system");
		if(!$this->con)
		{
			echo "Connection Failed!";
		}
	}
}

$obj = new Database;

?>