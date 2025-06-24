<?php
session_start();
include_once("./connectToDb.php");
$conn=connect();
$user_id = $_SESSION['user_id']; 
$feedback =trim( $_POST['feedback_text']);
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;

$sql = "INSERT INTO feedback (user_id, feedback_text, rating)
        VALUES ('$user_id', '$feedback', '$rating')";
$stmt = $conn->query($sql);


header("location: /bernhack/homepage/feedback.html");
?>



?>