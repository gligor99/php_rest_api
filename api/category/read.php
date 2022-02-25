<?php
//Headers
header('Access-Control-Allow-Origin: *'); //Access by everybody -> Public -> No Token or Auth
header('Content-Type: application/json');

include_once("../../config/Database.php");
include_once("../../models/Category.php");

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$category = new Category($db);

// Category Read Query
$result = $category->read();

// Get row Count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
    // Category array
    $cat_arr = array();
    $cat_arr['categories'] = array(); // Where the data will actually go


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id' => $id,
            'name' => $name,
        );

        // Push to 'DATA'
        array_push($cat_arr['categories'], $cat_item); //Loop to each post
    }

    //Turn to JSON & output array
    echo json_encode($cat_arr);

} else {
    // No Category
    echo json_encode(
        array('message' => "No Category Found")
    );
}
