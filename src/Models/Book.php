<?php

require_once("connection.php");

/* 
    A domain Class to demonstrate RESTful web services
*/
Class Book {
	
    /**
     * Instance of book.
     *
     * @var array
    */
    private $books = array();
    
    /**
     * DB connection intance.
     *
     * @var array
     */
    private $connection;

    /**
     * sql table name.
     *
     * @var string
     */
    private $tableName = 'books';


    public function getTableName(){
        return $this->tableName;
    }

    /**
     * Initializing Database connection,
     */
    function __construct() {
		$this->connection = new Connection();
	}

    /**
     * list of all the books available 
     *
     * @return array
     */
    public function getAllBooks(){
		$query = 'SELECT id,title,isbn,release_date,author_id FROM ' .$this->getTableName(). ' where deleted_at is null order by created_at desc';
		$this->books = $this->connection->executeSelectQuery($query);
		return $this->books;
	}

    /**
     * Adding up new book.
     *
     * @return array
     */
	public function addBook(){

		if(isset($_POST['title'])){
			$title = $_POST['title'];
			$isbn = $_POST['isbn'];
			if(isset($_POST['date'])){
				$date = $_POST['date'];
			}	
            $authorId = 1; // keeping dummy author.
            $query = "Insert into ".$this->getTableName()." (title,isbn,release_date,author_id) values ('" . $title ."','". $isbn ."','" . $date ."','" . $authorId ."')";
			$result = $this->connection->executeQueryAndGetInsertedId($query);

            $query = "Select id,title,isbn,release_date as date,author_id from ".$this->getTableName()." where id= ".$result['inserted_id'];
			$createdResult = $this->connection->executeSelectQuery($query);

            if($createdResult)
				return array('result'=>'success','data'=>$createdResult[0]);
		}
	}
	
    /**
     * Edit an existing book.
     *
     * @return array
     */
	public function editBook(){
		
        if(isset($_POST['title']) && isset($_GET['id'])){
			$title = $_POST['title'];
			$isbn = $_POST['isbn'];
			$date = $_POST['date'];
			$query = "UPDATE ".$this->getTableName()." SET title = '".$title."',isbn ='". $isbn ."',release_date = '". $date ."' WHERE id = ".$_GET['id'];
		}
	
		$result = $this->connection->executeQuery($query);

		if($result)
			return array('result'=>'success');
	}

    /**
     * setting up timestamp to current to delete book
     *
     * @return void
     */
	public function deleteBook(){
		
        if(isset($_GET['id'])){
			$id = $_GET['id'];
			$query = 'Update '.$this->getTableName().' set deleted_at = current_date() WHERE id = '.$id;
			
            $result = $this->connection->executeQuery($query);
			
            if($result)
				return array('result'=>'success');
		}
	}
    
}
?>