<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get data (ID) from GET
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Category 
    $category->read_single();

    // Create an array from newly fetched data now residing in category object
    $cat_arr = array(
        'id'=>$category->id,
        'name'=>$category->name
    );

    // Make JSON and output
    echo json_encode($cat_arr);
?>