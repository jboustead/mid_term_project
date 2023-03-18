<?php
class Author
{
    // DB Stuff
    private $conn;
    private $table = 'authors';

    // Author Properties
    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Author
    public function read() {
        // Create query
        $query = 'SELECT id, author FROM '. $this->table;

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category
    public function read_single() {
        // Create query
        $query = 'SELECT id, author FROM '.$this->table.' WHERE id = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // Set properties
            $this->id = $row['id'];
            $this->author = $row['author'];
        }
    }

    // Creat Post
    public function create() {
        // Create query
        $query = 'INSERT INTO authors (author) VALUES (:value1)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt->bindParam(':value1', $this->author);

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
        $query = 'UPDATE '.$this->table.' SET author = :author1 WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author1', $this->author);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}