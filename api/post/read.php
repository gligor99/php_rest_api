<?php
//Headers
header('Access-Control-Allow-Origin: *'); //Access by everybody -> Public -> No Token or Auth
header('Content-Type: application/json');

include_once("../../config/Database.php");
include_once("../../models/Post.php");

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$post = new Post($db);

// Blog Post Query
$result = $post->read();

// Get row Count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $posts_arr = array();
    $posts_arr['posts'] = array(); // Where the data will actually go


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to 'DATA'
        array_push($posts_arr['posts'], $post_item); //Loop to each post
    }
    
    //Turn to JSON & output array
    echo json_encode($posts_arr);

} else {
    // No Posts
    echo json_encode(
        array('message' => "No Posts Found")
    );
}
