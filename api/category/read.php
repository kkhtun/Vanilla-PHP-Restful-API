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

    // Category query
    $result = $category->read();

    // Get row count
    $num = $result->rowCount();
    // Check if any categories
    if ($num > 0) {
        // Category array
        $cat_arr = array();

        // Create data index to point data, in case there are other like pagination
        $cat_arr['data'] = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row); // No need to do $row['id'] as such
            $cat_item = array(
                'id'=> $id,
                'name'=>$name,
            );
            // Push to 'data'
            array_push($cat_arr['data'], $cat_item);
        }
        // Turn to JSON and output
        echo json_encode($cat_arr);
    
    } else {
        // No Categories
        echo json_encode(
            array('message'=> 'No Categories Found')
        );
    }

?>