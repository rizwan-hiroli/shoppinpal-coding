<?php

require_once("SimpleRest.php");
require_once("src/Models/Book.php");
		
class BookController extends SimpleRest {

	private $books;

	/**
	 * Injecting book class.
	 */
	function __construct() {
		$this->books = new Book();
	}
		
	/**
	 * get list of all books.
	 *
	 * @return json
	 */
	function index() {	

		$rawData = $this->books->getAllBooks();

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);		
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);	
		$result["result"] = 'success';
		$result["data"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	/**
	 * creating new book.
	 *
	 * @return json
	 */
	function create() {	
		
		$response = $this->validate();
		
		if($response['result'] == 'success'){
	
			$rawData = $this->books->addBook();	
			if(empty($rawData['data'])) {
				$statusCode = 404;		
			} else {
				$statusCode = 200;
			}
		}else{
			$statusCode = 400;
			$rawData = $response;
		}
		
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	
	/**
	 * updating existing book.
	 *
	 * @return void
	 */
	function update() {	

		//validate input.

		$rawData = $this->books->editBook();
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('result'=>'failure');	
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	/**
	 * deleting existing book.
	 *
	 * @return void
	 */
	function destroy() {	
		
		$rawData = $this->books->deleteBook();			
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('result' => 'failure');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	
	/**
	 * formatting output.
	 *
	 * @param [type] $responseData
	 * @return json
	 */
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}

	
	/**
	 * Validating input requests.
	 *
	 * @return array
	 */
	function validate(){
		$response = ['result'=>'success','message'=>[]];
		if(!isset($_POST['title'])){
			$response['result'] ='failure';
			$response['message']['title'] = 'Title is required.';	
		}
		if(!isset($_POST['isbn'])){
			$response['result'] = 'failure';
			$response['message']['isbn'] ='ISBN is required.';
		}
		if(!isset($_POST['date'])){
			$response['result'] = 'failure';
			$response['message']['release_date'] = 'Release date is required.';
		}
		return $response;
	}
}
?>