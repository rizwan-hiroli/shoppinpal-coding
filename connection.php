<?php
class Connection {
	private $conn = "";
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "shopping_pal";

    /**
     * Injecting Db connection.
     */
	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->conn = $conn;			
		}
	}

    /**
     * Connecting to DB.
     *
     * @return void
     */
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}

    /**
     * Inserting and getting inserted id.
     *
     * @param [string] $query
     * @return array
     */
    function executeQueryAndGetInsertedId($query) {
        $conn = $this->connectDB();    
        $result = mysqli_query($conn, $query);
        if (!$result) {
            //check for duplicate entry
            if($conn->errno == 1062) {
                return false;
            } else {
                trigger_error (mysqli_error($conn),E_USER_NOTICE);
				
            }
        }		
        $affectedRows = mysqli_affected_rows($conn);
		return ['affected_rows'=>$affectedRows,'inserted_id'=>$conn->insert_id];
		
    }

    /**
     * Running query.
     *
     * @param [string] $query
     * @return array
     */
	function executeQuery($query) {
        $conn = $this->connectDB();    
        $result = mysqli_query($conn, $query);
        if (!$result) {
            //check for duplicate entry
            if($conn->errno == 1062) {
                return false;
            } else {
                trigger_error (mysqli_error($conn),E_USER_NOTICE);
				
            }
        }		
        $affectedRows = mysqli_affected_rows($conn);
		return $affectedRows;		
    }

    /**
     * getting data from DB.
     *
     * @param [string] $query
     * @return void
     */
	function executeSelectQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset))
			return $resultset;
	}
}
?>
