<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Chat.php';

  $database = new Database();
  $db = $database->connect();

  $post = new Post($db);

  //  post query
  $result = $post->read();

  echo json_encode(
        $result->fetchAll(PDO::FETCH_ASSOC)
      );

