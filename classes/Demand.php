<?php

class Demand {
    private $conn;
    public function __construct($db) {
        if (method_exists($db, 'getConnection')) {
            $this->conn = $db->getConnection();
        } else {
            throw new Exception("Invalid database object provided.");
        }
    }
    

    // Authenticate the student
    public function authenticate($id, $password) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = $user['status'];

            return true;
        } else {
            return "Invalid ID or Password.";
        }
    }

    // Fetch a student's profile
    public function getProfile($student_id) {
        $query = "SELECT first_name, last_name, id FROM users WHERE id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all demands of a student
    public function getDemands($student_id) {
        $query = "SELECT demands.*, users.first_name, users.last_name 
                  FROM demands 
                  JOIN users ON demands.id = users.id 
                  WHERE demands.id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new demand
    public function addDemand($student_id, $document, $urgency) {
        $query = "INSERT INTO demands (id, document, urgency, status) 
                  VALUES (:student_id, :document, :urgency, 'encours')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':document', $document);
        $stmt->bindParam(':urgency', $urgency);

        return $stmt->execute();
    }

    // Update the status of a demand
    public function updateDemandStatus($demand_id, $document, $action) {
        $new_status = ($action === 'accepter') ? 'accepted' : 'rejected';
        $query = "UPDATE demands SET status = :new_status WHERE id = :demand_id AND document = :document";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':new_status', $new_status);
        $stmt->bindParam(':demand_id', $demand_id);
        $stmt->bindParam(':document', $document);

        return $stmt->execute();
    }

    // Fetch all unapproved students
    public function getUnapprovedStudents() {
        $query = "SELECT id, first_name, last_name, status 
                  FROM users 
                  WHERE role = 'student' AND status != 'approved'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update the status of a student
    public function updateStudentStatus($student_id, $status) {
        $query = "UPDATE users SET status = :status WHERE id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':student_id', $student_id);

        return $stmt->execute();
    }

    // Delete a student
    public function deleteStudent($student_id) {
        $query = "DELETE FROM users WHERE id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);

        return $stmt->execute();
    }

    public function checkExistingDemand($studentId, $document) {
        $query = "SELECT * FROM demands WHERE id = :studentId AND document = :document";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->bindParam(':document', $document);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function createDemand($studentId, $document, $urgency) {
        $query = "INSERT INTO demands (id, document, urgency, status) 
                  VALUES (:studentId, :document, :urgency, 'encours')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->bindParam(':document', $document);
        $stmt->bindParam(':urgency', $urgency);
        return $stmt->execute();
    }
}
?>
