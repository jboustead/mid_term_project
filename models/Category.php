<?php

class Category
{
    // DB Stuff
    private $conn;
    private $table = 'categories';

    // Author Properties
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get categories
    public function read() {
        // Create query
        $query = 'SELECT id, category FROM '. $this->table;

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category
    public function read_single() {
        // Create query
        $query = 'SELECT id, category FROM '. $this->table.' WHERE id = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($row['category'])) {
            // Set properties
            $this->id = $row['id'];
            $this->category = $row['category'];
        }
    }

    // Creat Post
    public function create() {
        // Create query
        $query = 'INSERT INTO '.$this->table.' (category) VALUES (:value1)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind data
        $stmt->bindParam(':value1', $this->category);

        // Execute query
        if($stmt->execute()) return true;

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        // Create query
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update() {
        // Create query
        $query = 'UPDATE '.$this->table.' SET category = :category1 WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category1', $this->category);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function findID () {
        $query = 'SELECT id FROM '.$this->table.' WHERE category = \''.$this->category.'\' LIMIT 1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }
}