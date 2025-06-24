<?php
include_once("./connectToDb.php");
$conn=connect();
$sql="select * from events where status='pending'";
$result=$conn->query($sql);






 while($row = $result->fetch_assoc()):?>
    <div>
        <p>title: <?=$row['title']?></p>
        <p>description: <?=$row['description']?></p>
        <p>date: <?=$row['date']?></p>
        <p>time: <?=$row['time']?></p>
        <p>location: <?=$row['location']?></p>



 
    <form action="/bernhack/backend/update_status.php" method="post">
        <input type="hidden" name="event_id" value="<?= $row['id']?>">
        <button type="submit" name="action" value="approve">approve</button>
        <button type="submit" name="action" value="deny">deny</button>

    </form>
   </div>
   <?php endwhile; ?>