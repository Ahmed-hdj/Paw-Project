<?php
class Professor {
    private $db;

    // Constructor receives a Database object for dependency injection
    public function __construct(Database $db) {
        $this->db = $db;
    }

    // Add a new professor using prepared statements (PDO)
    public function addProfessor($prof_name, $module, $email) {
        $conn = $this->db->getConnection();

        // Prepare the SQL query to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO professors (prof_name, module, email) VALUES (:prof_name, :module, :email)");

        // Bind parameters to the prepared statement
        $stmt->bindParam(':prof_name', $prof_name, PDO::PARAM_STR);
        $stmt->bindParam(':module', $module, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            return true;
        } else {
            return "Error: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Fetch all professors using PDO
    public function getProfessors() {
        $conn = $this->db->getConnection();

        // Prepare the SQL query to fetch professors
        $stmt = $conn->prepare("SELECT * FROM professors");

        // Execute the query
        $stmt->execute();

        // Check if there are any rows returned
        if ($stmt->rowCount() > 0) {
            // Fetch all rows as an associative array
            $professors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $professors;
        } else {
            // No rows found
            return [];
        }
    }
}


?>
