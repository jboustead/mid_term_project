<?php
class Quote
{
    // DB Stuff
    private $conn;
    private $table = 'quotes';

    // Author Properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Quote
    public function read()
    {
        // Create query
        $query = 'SELECT DISTINCT t1.id, t1.quote, ft1.author, ft2.category
            FROM '. $this->table.' t1
            JOIN authors ft1 ON t1.author_id = ft1.id
            JOIN categories ft2 ON t1.category_id = ft2.id
            ORDER BY t1.id ASC;';

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get method when author_id and/or category_id are included in the GET request
    public function read_category()
    {
        // Create query
       if ($this->category_id != null && $this->author_id == null) {
           // query if only author_id is input with the GET request
           $query = 'SELECT 
	            q.id,
                q.quote,
                a.author,
                c.category
            FROM 
	            ' .$this->table. ' q
                JOIN authors a ON q.author_id = a.id
                JOIN categories c ON q.category_id = c.id
                WHERE c.id = ?';
       } elseif ($this->category_id == null && $this->author_id != null) {
           $query = 'SELECT 
	            q.id,
                q.quote,
                a.author,
                c.category
            FROM 
	            ' .$this->table. ' q
                JOIN authors a ON q.author_id = a.id
                JOIN categories c ON q.category_id = c.id
                WHERE a.id = ?';
       }
       else {
           // query if both author_id and category_id were included in the GET request
           $query = 'SELECT 
	            q.id,
                q.quote,
                a.author,
                c.category
            FROM 
	            ' .$this->table. ' q
                JOIN authors a ON q.author_id = a.id
                JOIN categories c ON q.category_id = c.id
                WHERE a.id = ? AND c.id = ?';
       }

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        if ($this->category_id != null && $this->author_id == null) {
            $stmt->bindParam(1, $this->category_id);
        } elseif ($this->category_id == null && $this->author_id != null) {
            $stmt->bindParam(1, $this->author_id);
        } else {
            $stmt->bindParam(1, $this->author_id);
            $stmt->bindParam(2, $this->category_id);
        }

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category
    public function read_single() {
        // Create query
        $query = 'SELECT 
	            q.id,
                q.quote,
                a.author,
                c.category
            FROM 
	            ' .$this->table. ' q
                JOIN authors a ON q.author_id = a.id
                JOIN categories c ON q.category_id = c.id
                WHERE q.id = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($row['quote'])) {
            // Set properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author'];
            $this->category_id = $row['category'];
        }
    }

    // Creat Post
    public function create() {
        // Create query
        $query = 'INSERT INTO '. $this->table .'
                (quote, author_id, category_id)
            VALUES
                (:value1, :value2, :value3)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));

        // Bind data
        $stmt->bindParam(':value1', $this->quote);
        $stmt->bindParam(':value2', $this->author_id);
        $stmt->bindParam(':value3', $this->category_id);

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
        $query = 'UPDATE '.$this->table.' SET quote = :quote2, author_id = :quote3, category_id = :quote4 WHERE id = :quote1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));

        // Bind data
        $stmt->bindParam(':quote1', $this->id);
        $stmt->bindParam(':quote2', $this->quote);
        $stmt->bindParam(':quote3', $this->author_id);
        $stmt->bindParam(':quote4', $this->category_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}