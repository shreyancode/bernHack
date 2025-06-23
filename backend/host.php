<?php
session_start();
include_once("./connectToDb.php");
$conn = connect();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $time = $_POST['time'];
    $result = $conn->query("INSERT INTO events(user_id,title,description,date,time,location) values('$host_id','$title','$description','$date','$time','$location')");
   $event_id = $conn->insert_id;

 if (isset($_POST['labels']) && isset($_POST['types'])) {
        $labels = $_POST['labels'];
        $types = $_POST['types'];
        $is_reqs = isset($_POST['is_req']) ? $_POST['is_req'] : [];

        for ($i = 0; $i < count($labels); $i++) {
            $label = $labels[$i];
            $type = $types[$i];
            $is_required = isset($is_reqs[$i]) ? 1 : 0;

            $conn->query("INSERT INTO form_fields(event_id, label, field_type, is_req)
                          VALUES('$event_id', '$label', '$type', '$is_required')");
        }
    }

    echo "Event and custom form fields created!";
}


?>
