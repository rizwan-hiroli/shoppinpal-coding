<?php
require_once("src/Controllers/BookController.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";
if(isset($_GET["page_key"]))
	$page_key = $_GET["page_key"];

$books = new BookController();
/*
controls the RESTful services
URL mapping
*/
	switch($page_key){

		case "list":
			// to handle REST Url /books/list/			
			$result = $books->index();
			break;
	
		case "create":
			// to handle REST Url /books/create/
			$books->create();
		break;
		
		case "delete":
			// to handle REST Url /books/delete/<row_id>
			$result = $books->destroy();
		break;
		
		case "update":
			// to handle REST Url /books/update/<row_id>
			$books->update();
		break;
}
?>
