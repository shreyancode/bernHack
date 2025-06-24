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
$target_dir = "../uploads/";
$image_path = $target_dir . $_FILES["event_image"]["name"];
    

if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $image_path)) {
        $result = $conn->query("INSERT INTO events(user_id,title,description,date,time,location,image_path) values('$host_id','$title','$description','$date','$time','$location','$image_path')");

}

   $event_id = $conn->insert_id;


 if (isset($_POST['labels']) && isset($_POST['types'])) {
        $labels = $_POST['labels'];
        $types = $_POST['types'];
        $is_reqs = isset($_POST['is_req']) ? $_POST['is_req'] : [];

        for ($i = 0; $i < count($labels); $i++) {
            $label = $labels[$i];
            $type = $types[$i];
            $is_required = isset($is_reqs[$i]) ? 1 : 0;

            $conn->query("INSERT INTO form_fields(event_id, label, field_type, is_required)
                          VALUES('$event_id', '$label', '$type', '$is_required')");
        }
    }

    echo "<script> alert('Event and custom form fields created!')";
    header("location:/bernhack/frontend/host1.html");
}


?>
