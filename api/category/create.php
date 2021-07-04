<?php

	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	// Include required code
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';


	// Instantiate and Connect to DB
	$database = new Database();
	$db = $database->connect();

	// Instantiate Category Object
	$category = new Category($db);

	// Get raw input data from POST request
	$data = json_decode(file_get_contents("php://input"));

	$category->name = $data->name;

	// Create category and catch if not created
	if ($category->create()) {
		echo json_encode(array(
			'message'=>'Category Created'
		));
	} else {
		echo json_encode(array(
			'message'=>'Category Not Created'
		));
	}
?>