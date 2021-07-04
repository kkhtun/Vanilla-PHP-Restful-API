<?php
	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	include_once '../../config/Database.php';
	include_once '../../models/Category.php';

	// Instantiate DB and Connect
	$database = new Database();
	$db = $database->connect();

	// Instantiate Category Model Object
	$category = new Category($db);

	// Get raw input data from DELETE request
	$data = json_decode(file_get_contents("php://input"));
	
	$category->id = $data->id;

	// Delete Category
	if ($category->delete()) {
		echo json_encode(array(
			'message'=>'Category Deleted'
		));
	} else {
		echo json_encode(array(
			'message'=>'Category Not Deleted'
		));
	}
?>