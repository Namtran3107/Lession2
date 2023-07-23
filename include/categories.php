<?php  
class categories{

	//DB params
	private $table = "categories";
	private $conn;

	//Myguests properties
	public $id;
	public $category_name;
	public $parent_id;

	public function __construct($db){
		$this->conn = $db;
	}

	//Read all records
	public function read_all(){
		$sql = "SELECT * FROM $this->table";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public function search($category_name){
	$sql = "SELECT * FROM $this->table WHERE category_name LIKE :new_category_name";
    $stmt = $this->conn->prepare($sql);
    $search_value = '%'.$category_name.'%'; 
    $stmt->bindValue(":new_category_name", $search_value);
    $stmt->execute();
    return $stmt;
	}

	//Read one record
	public function read(){
		$sql = "SELECT * FROM $this->table WHERE id = :get_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":get_id",$this->id);
		$stmt->execute();
		$row = $stmt->fetch();
		$this->id = $row['id'];
		$this->category_name = $row['category_name'];
		$this->parent_id = $row['parent_id'];
	}

	//Add record
	public function add(){
		$sql = "INSERT INTO $this->table SET category_name = :new_category_name,
											parent_id = :new_parent_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":new_category_name",$this->category_name);
		$stmt->bindParam(":new_parent_id",$this->parent_id);

		try{
			if($stmt->execute()){
				return true;
			}
		}catch(PDOException $e){
			echo "Error insert record: <br>".$e->getMessage();
			return false;
		}
	}
	public function add_item(){
		$sql = "INSERT INTO $this->table SET category_name = :new_category_name,
											parent_id = :new_parent_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":new_category_name",$this->category_name);
		$stmt->bindParam(":new_parent_id",$this->parent_id);

		try{
			if($stmt->execute()){
				return true;
			}
		}catch(PDOException $e){
			echo "Error insert record: <br>".$e->getMessage();
			return false;
		}
	}

	//Update record
	public function update(){
		$sql = "UPDATE $this->table
				SET category_name = :new_category_name,
					parent_id = :new_parent_id
				WHERE id = :get_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":get_id",$this->id);
		$stmt->bindParam(":new_category_name",$this->category_name);
		$stmt->bindParam(":new_parent_id",$this->parent_id);
		try{
			if($stmt->execute()){
				return true;
			}
		}catch(PDOException $e){
			echo "Error update record: <br>".$e->getMessage();
			return false;
		}
	}

	//Delete record
	public function delete(){
		$sql = "DELETE FROM $this->table WHERE id = :get_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":get_id",$this->id);

		try{
			if($stmt->execute()){
				return true;
			}
		}catch(PDOException $e){
			echo "Error delete record: <br>".$e->getMessage();
			return false;
		}
	}
}
?>