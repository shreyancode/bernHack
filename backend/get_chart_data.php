<?php
include_once("./connectToDb.php");
$conn=connect();

$sql = "SELECT e.title, COUNT(fs.id) AS submission_count FROM events e LEFT JOIN form_submissions fs ON e.id = fs.event_id GROUP BY e.id";
$result=$conn->query($sql);

if ( $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'title' => $row['title'],
            'submission_count' => (int)$row['submission_count']
        ];
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>