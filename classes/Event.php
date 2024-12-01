<?php
class EventController {
    private $event;

    public function __construct($event) {
        $this->event = $event;
    }

    // Display all events
    public function displayEvents() {
        $events = $this->event->getEvents();

        if (count($events) > 0) {
            foreach ($events as $event) {
                echo "<div class='bg-white rounded-md shadow-md p-5 tracking-[1px] mb-4'>";
                echo "<h1 class='underline underline-offset-4 text-cblue uppercase text-xl font-semibold mb-5'>" . htmlspecialchars($event['event_title']) . "</h1>";
                echo "<p class='text-gray-900 font-medium'>" . htmlspecialchars($event['event_description']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No events found.</p>";
        }
    }
}
?>
