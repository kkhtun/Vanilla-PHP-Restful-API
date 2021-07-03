<?php

class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Category properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Categories
    public function read() {
        $query = 'SELECT 
            id,
            name,
            created_at
        FROM
            ' . $this->table . '
        ORDER BY
            created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute
        $stmt->execute();
        return $stmt;
    }

    // Get Single Category
    public function read_single() {
        // Create query
        $query = 'SELECT 
            id,
            name,
            created_at
        FROM
            ' . $this->table . ' 
        WHERE 
            id = :id 
        LIMIT
            0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID (named here, contrary to positional in post)
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }

}

?>