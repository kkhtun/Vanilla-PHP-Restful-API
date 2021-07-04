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

    // Create a new category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean Input Data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind Params (named parameters, remember colons!)
        $stmt->bindParam(':name', $this->name);

        // Execute statement
        if ($stmt->execute()) {
            return true;
        }
        // Print error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Category
    public function update() {
        // Create update query
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean Input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind Params
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name',$this->name);

        // Execute statement
        if ($stmt->execute()) {
            return true;
        }
        // Printf error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Category
    public function delete() {
        // Create Query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean Input
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Params (named)
        $stmt->bindParam(':id', $this->id);

        // Execute Statement
        if ($stmt->execute()) {
            return true;
        }
        // Printf error if sth goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}

?>