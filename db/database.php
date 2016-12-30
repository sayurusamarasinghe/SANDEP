 <?php
	class connection{
	
		public $conn;
		
		public function __construct(){
			//Creating the Database connectivity
			$this->conn = mysqli_connect("localhost","root","") or die(mysqli_error($this->conn));
			//Selecting the required Database
			mysqli_select_db($this->conn, "sandep") or die(mysqli_error($this->conn));
		}
		
		public function insert($table, $values){
			$str = "INSERT INTO ".$table." VALUES(".$values.");"; //echo $str;
			$this->query($str);
		}
		public function insertWithCol($table,$columns, $values){
			$str = "INSERT INTO ".$table." (".$columns.")VALUES(".$values.")";
			$this->query($str);
		}
		
		public function select($table, $columns, $condition){
			$str = "SELECT ".$columns." FROM ".$table." WHERE ".$condition.";";
			$query = $this->query($str);
			return $query;
		}
		
		public function fetch_assoc($query){
			return mysqli_fetch_assoc($query);
		}
		
		public function num_rows($query){						
			return mysqli_num_rows($query);
		}
		
		public function select_record($table, $columns, $condition){
			return $this->fetch_assoc($this->select($table, $columns, $condition));
		}
		
		public function view($table, $columns, $condition){
			$query = $this->select($table, $columns, $condition);
			$this->print_query($query);
		}
		
		public function delete($table, $condition){
			$str = "DELETE FROM ".$table." WHERE ".$condition.";";
			$this->query($str);
		}
		
		public function update($table, $column, $value, $condition){
			$str = "UPDATE ".$table." SET ".$column."='".$value."' WHERE ".$condition.";";
			$this->query($str);
		}
		
		//select and make in ascending order
		public function select_and_order_ASC($table, $columns, $condition, $order_by){			
			$str = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$order_by." ASC;";
			$query = $this->query($str);
			return $query;
		}
		
		//select and make in descending order
		public function select_and_order_DESC($table, $columns, $condition, $order_by){	
			$str = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$order_by." DESC;";
			$query = $this->query($str);
			return $query;
		}
		
		//group and make in ascending order
		public function select_and_group($table, $columns, $condition, $group_by){
			$str = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." GROUP BY ".$group_by." ASC;";
			$query = $this->query($str);
			return $query;
		}
		
		
		public function query($str){ //echo $str;
			return mysqli_query($this->conn,$str);
		}
		
		public function select_with_pagenation($table, $columns, $condition, $page){
			$num_records_per_page = 10;
			$page*=$num_records_per_page;
			$str = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." LIMIT ".$page." , ".$num_records_per_page.";";
			$query = $this->query($str);
			return $query;
		}
		
	}
?>