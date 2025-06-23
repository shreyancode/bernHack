<?php
session_start();
include_once("./connectToDb.php");
$conn=connect();
if(!isset($_GET['event_id'])){
    die("id missing");
}
$event_id=$_GET['event_id'];
$result=$conn->query("select title,description,date,time,location from events where id='event_id' and status='approved'");
if($result->num_rows === 0)
{
    die("event not found or not approved");

}
$eventRes=$event->fetch_assoc();


?>