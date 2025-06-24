<?php
include_once("./connectToDb.php");
$conn=connect();
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$sql = "SELECT id, title, description, image_path FROM events 
        WHERE status = 'approved' 
        AND (
            date < '$currentDate' OR 
            (date = '$currentDate' AND time < '$currentTime')
        )
        ";

$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);
?>
