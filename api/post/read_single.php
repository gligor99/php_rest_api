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

// Get ID From URL
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Call Read Single Method
// Get post
$post->read_single();

// Create Array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

// Convert to JSON
print_r(json_encode($post_arr));
