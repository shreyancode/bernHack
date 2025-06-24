<?php
include_once("./connectToDb.php");
$conn=connect();
$sql="select * from events where status='pending'";
$result=$conn->query($sql);






 while($row = $result->fetch_assoc()):?>
    <div class="event-card">
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
   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Event Card Container */
.event-card {
    background-color: #ffffff;
    padding: 25px 30px;
    margin: 20px auto;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    max-width: 600px;
    font-family: 'Segoe UI', sans-serif;
    box-sizing: border-box;
}

/* Event Details */
.event-card p {
    font-size: 16px;
    color: #333;
    margin: 8px 0;
    line-height: 1.4;
}

/* Approve/Deny Form */
.event-card form {
    margin-top: 20px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

/* Buttons */
.event-card button {
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Approve Button */
.event-card button[name="action"][value="approve"] {
    background-color: #22c55e;
    color: white;
}

.event-card button[name="action"][value="approve"]:hover {
    background-color: #16a34a;
}

/* Deny Button */
.event-card button[name="action"][value="deny"] {
    background-color: #ef4444;
    color: white;
}

.event-card button[name="action"][value="deny"]:hover {
    background-color: #dc2626;
}

    </style>
   </head>
   <body>
    
   </body>
   </html>
   <?php endwhile; ?>