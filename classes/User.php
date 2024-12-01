<?php
class User {
    private $db;

    // Constructor receives a Database object for dependency injection
    public function __construct($db) {
        $this->db = $db;
    }

    // Authenticate the user by checking matricule (id) and password
    public function authenticate($id, $password) {
        // Prepare the SQL query to find the user by id
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id); // Bind the user id parameter
        $stmt->execute();

        // Fetch the user from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the user's status is 'pending'
            if ($user['status'] == 'pending') {
                return "Your account is pending approval.";
            }

            // Check if the password is correct
            if (password_verify($password, $user['password'])) {
                // Start the session if not already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Store user information in the session
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = $user['status'];

                return true; // Successful authentication
            } else {
                return "Invalid ID or Password."; // Authentication failed
            }
        } else {
            return "Invalid ID or Password."; // User not found
        }
    }

    // Update status for a specific user
    public function updateStatus($user_id, $status) {
        $query = "UPDATE users SET status = :status WHERE id = :user_id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // Delete user from the system
    public function deleteUser($user_id) {
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // Fetch students who are not approved
    public function getUnapprovedStudents() {
        $query = "SELECT id, first_name, last_name, status FROM users WHERE role = 'student' AND status != 'approved'";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get user by id
    public function getUserById($id) {
        $query = "SELECT first_name, last_name, id FROM users WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
