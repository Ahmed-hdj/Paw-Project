<?php
class AdminEvent {
    private $db;

    // Constructor receives a Database object for dependency injection
    public function __construct($db) {
        $this->db = $db;
    }

    // Handle event creation
    public function createEvent($title, $content) {
        if (!empty($title) && !empty($content)) {
            $query = "INSERT INTO events (event_title, event_description) VALUES (:title, :content)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            if ($stmt->execute()) {
                return "Event added successfully!";
            } else {
                return "Error: Unable to add event.";
            }
        } else {
            return "Please fill in all fields.";
        }
    }

    // Fetch all events
    public function getEvents() {
        $query = "SELECT event_title, event_description FROM events ORDER BY event_title ASC";
        $stmt = $this->db->getConnection()->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update event details (if needed)
    public function updateEvent($event_id, $title, $content) {
        $query = "UPDATE events SET event_title = :title, event_description = :content WHERE event_id = :event_id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($event_id) {
        $query = "DELETE FROM events WHERE event_id = :event_id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        return $stmt->execute();
    }
}
?>