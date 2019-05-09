<?php  

class Database {
	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $dbname = 'simple-api';
	public $conn;
	public function connect() {
		$this->conn = Null;
		$this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);
		if (mysqli_connect_errno()){
	  		echo "MYSQL Connect Error: " . mysqli_connect_error();
	  	}
	  	return $this->conn;
	}
}




?>