<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Chat.php';


  $database = new Database();
  $db = $database->connect();


  $post = new Post($db);

  $data = json_decode(file_get_contents("php://input"));

  $post->user_1 = $data->user_1;
  $post->user_2 = $data->user_2;
  $post->message = $data->message;

  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

