<?php
//Headers
header('Access-Control-Allow-Origin: *'); //Access by everybody -> Public -> No Token or Auth
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With ');

// X-Requested-With => Helps with cross site scripting attacks, with cores ...

include_once("../../config/Database.php");
include_once("../../models/Post.php");

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input")); // Give as whatever is submitted

// Assign what we have in data to the post
$post->title = $data->title;
$post->author = $data->author;
$post->body = $data->body;
$post->category_id = $data->category_id;

// Create Post -> Using Method we created in model
if ($post->create()) {
    echo json_encode(
        array("message" => "Post Created")
    );
} else {
    echo json_encode(
        array("message" => "Post Not Created")
    );
}
