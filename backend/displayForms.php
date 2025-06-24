<?php
session_start();
include_once("./connectToDb.php");
$conn = connect();

if (!isset($_GET['event_id'])) {
    die("Event ID missing.");
}

$event_id =$_GET['event_id']; 


$result = $conn->query("SELECT title, description, date, time, location FROM events WHERE id = '$event_id' AND status = 'approved'");

if ($result->num_rows === 0) {
    die("Event not found or not approved.");
}

$event = $result->fetch_assoc();

echo "<h2>" . $event['title'] . "</h2>";
echo "<p>" . $event['description'] . "</p>";
echo "<p>Date: " . $event['date'] . " Time: " . $event['time'] . "</p>";
echo "<p>Location: " . $event['location']. "</p>";


$res = $conn->query("SELECT id, label, field_type, is_required FROM form_fields WHERE event_id = '$event_id'");

if ($res->num_rows > 0) {
    echo "<form action='submitForm.php' method='POST'>";
    echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";

    while ($field = $res->fetch_assoc()) {
        $label = $field['label'];
        $field_type = $field['field_type'];
        $is_required = $field['is_required'] ? "required" : "";

        echo "<label>$label";
        if ($is_required) echo " *";
        echo "</label><br>";

        if ($field_type === "checkbox") {
            echo "<input type='checkbox' name='field_" . $field['id'] . "' value='1' $is_required><br><br>";
        } else {
            echo "<input type='$field_type' name='field_" . $field['id'] . "' $is_required><br><br>";
        }
    }

    echo "<button type='submit'>Submit</button>";
    echo "</form>";
} else {
    echo "<p>No form fields for this event.</p>";
}
?>
