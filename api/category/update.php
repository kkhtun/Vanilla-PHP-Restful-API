<?php

	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: PUT');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	include_once '../../config/Database.php';
	include_once '../../models/Category.php';

	// Instantiate DB and Connection
	$database = new Database();
	$db = $database->connect();

	// Instantiate Category Model Object
	$category = new Category($db);

	// Get raw input from PUT request
	$data = json_decode(file_get_contents("php://input"));

	$category->id = $data->id;
	$category->name = $data->name;

	// Update Category
	if ($category->update()) {
		echo json_encode(array(
			'message'=>'Category Updated'
		));
	} else {
		echo json_encode(array(
			'message'=>'Category Not Updated'
		));
	}

?>
