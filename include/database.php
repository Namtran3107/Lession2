<?php  
class database{
	//DB params
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "thuctap";
	private $conn;

	//DB connect
	public function connect(){
		$this->conn = null;
		
		try{
			$this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database",$this->username,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo "Error connection: <br>".$e->getMessage();
		}
		return $this->conn;
	}
}
?>