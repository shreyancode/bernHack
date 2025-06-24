<?php
include_once("./connectToDb.php");
$conn=connect();
$sql="select title,description from events where status='approved'";
$result=$conn->query($sql);
$events=[];
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $events[]=$row;
    }
}
echo json_encode($events,JSON_PRETTY_PRINT);
$conn->close();




?>