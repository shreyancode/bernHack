<?php
include_once("./connectToDb.php");
$conn = connect();

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

$sql = "SELECT id, title, description, image_path, date, time, location 
        FROM events 
        WHERE status = 'approved' 
        AND (
            date > '$currentDate' OR 
            (date = '$currentDate' AND time >= '$currentTime')
        )";

$result = $conn->query($sql);
$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events, JSON_PRETTY_PRINT);
$conn->close();
?>
