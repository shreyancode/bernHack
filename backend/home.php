<?php
include_once("./connectToDb.php");
$conn=connect();
$sql="select id,title,description,date,time,location from events where status='approved'";
$result=$conn->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        echo "<a href='displayForms.php?event_id=".$row['id']."'>".$row['title']."</a>";
    }
}
else{
    echo "no events found";
}

?>