<?php 
class Post
{
    // DB stuff
  private $conn;
  private $table = 'Chat';
  public $user_1;
  public $user_2;
  public $message;

    // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

    // Get messages
  public function read()
  {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $parts = parse_url($actual_link);
    parse_str($parts['query'], $qry);
    
    $query = 'SELECT t.* FROM (SELECT * FROM Chat WHERE user_1 = :user1 AND user_2 = :user2 OR user_1 = :user2 AND user_2 = :user1 ORDER BY timestamp DESC LIMIT 20) AS t ORDER BY timestamp ASC';
   
    $stmt = $this->conn->prepare($query);
    $this->user_1 = htmlspecialchars(strip_tags($qry['user_1']));
    $this->user_2 = htmlspecialchars(strip_tags($qry['user_2']));

    $stmt->bindParam(':user1', $this->user_1);
    $stmt->bindParam(':user2', $this->user_2);

    $stmt->execute();

    return $stmt;
  }

    // insert new chat
  public function create()
  {
    $query = 'INSERT INTO ' . $this->table . ' SET user_1 = :user1, message = :message, user_2 = :user2';


    $stmt = $this->conn->prepare($query);


    $this->user_1 = htmlspecialchars(strip_tags($this->user_1));
    $this->user_2 = htmlspecialchars(strip_tags($this->user_2));
    $this->message = htmlspecialchars(strip_tags($this->message));

    $stmt->bindParam(':user1', $this->user_1);
    $stmt->bindParam(':user2', $this->user_2);
    $stmt->bindParam(':message', $this->message);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }


}