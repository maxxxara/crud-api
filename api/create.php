<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require ('../config/Database.php');
require ('../modules/Post.php');

$database = new Database;
$db = $database->connect();

$post = new Post($db);
$post->create();







?>