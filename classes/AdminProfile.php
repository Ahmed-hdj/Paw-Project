<?php
// AdminProfile.php
class AdminProfile {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProfile($userId) {
        // Query to fetch profile by user ID
        $profile_query = "SELECT first_name, last_name, id FROM users WHERE id = :userId";
        
        // Prepare the query
        $stmt = $this->conn->prepare($profile_query);

        // Bind the parameter using PDO's bindParam method
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch and return the result
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
