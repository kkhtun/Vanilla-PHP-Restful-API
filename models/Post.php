<?php

class Post {

    // DB Stuff
    private $conn;
    private $table = 'Posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT c.name as category_name, 
        p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM '. $this->table . ' p 
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function read_single() {
        // Create query
        $query = 'SELECT c.name as category_name, 
        p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM '. $this->table . ' p 
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?
        LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID (positional)
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // Create post
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data Params (named params, dun forget the colons!)
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update post
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id=:id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data Params (named params, dun forget the colons!)
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Post
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean ID
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data (Param ID)
        $stmt->bindParam(':id', $this->id);

        // Execute ID
        if ($stmt->execute()) {
            return true;
        }
        // Print error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

?>