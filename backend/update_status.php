<?php
include_once("./connectToDb.php");
$conn=connect();

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['event_id'], $_POST['action'])){
$event_id=$_POST['event_id'];
$action=$_POST['action'];
$status=($action==="approve")?"approved":"denied";
$conn->query("update events set status='$status' where id='$event_id'");

}
header("location: /bernhack/frontend/admin1.html");
exit();
?>