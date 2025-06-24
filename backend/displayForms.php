<?php
session_start();
include_once("./connectToDb.php");
$conn = connect();

if (!isset($_GET['event_id'])) {
    die("Event ID missing.");
}

$event_id =$_GET['event_id']; 


$result = $conn->query("SELECT title, description, date, time, location FROM events WHERE id = '$event_id' AND status = 'approved'");

if ($result->num_rows === 0) {
    die("Event not found or not approved.");
}

$event = $result->fetch_assoc();
echo "<h2 class='heading'>" . $event['title'] . "</h2>";
echo "<div class='container'>";

echo "<p class='text'>" . $event['description'] . "</p>";
echo "<p class='date'>Date: " . $event['date'] . " Time: " . $event['time'] . "</p>";
echo "<p class='location'>Location: " . $event['location']. "</p>";


$res = $conn->query("SELECT id, label, field_type, is_required FROM form_fields WHERE event_id = '$event_id'");

if ($res->num_rows > 0) {
    echo "<form action='' method='POST'>";
    echo "<input  type='hidden' name='event_id' value='" . $event_id . "'>";

    while ($field = $res->fetch_assoc()) {
        $label = $field['label'];
        $field_type = $field['field_type'];
        $is_required = $field['is_required'] ? "required" : "";

        echo "<label>$label";
        if ($is_required) echo " *";
        echo "</label><br>";

        if ($field_type === "checkbox") {
            echo "<input class='checkbox' type='checkbox' name='field_" . $field['id'] . "' value='1' $is_required><br><br>";
        } else {
            echo "<input class='textbox' type='$field_type' name='field_" . $field['id'] . "' $is_required><br><br>";
        }
    }
echo "<div class='button'><button type='submit'>Submit</button></div>";

    echo "</form>";
} else {
    echo "<p>No form fields for this event.</p>";
}
echo "</div>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      * {
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

body {
    background: #f7f9fc;
    padding: 30px;
}

.heading {
    text-align: center;
    font-size: 36px;
    color: #2c3e50;
    margin-bottom: 30px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.container {
    background: #ffffff;
    max-width: 700px;
    margin: 0 auto;
    padding: 40px 50px;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.container p {
    font-size: 16px;
    color: #444;
    margin-bottom: 20px;
}

.container .text,
.container .date,
.container .location {
    font-weight: 500;
    text-transform: capitalize;
    color: #2c3e50;
}

label {
    display: block;
    font-weight: 600;
    color: #34495e;
    margin-top: 20px;
    margin-bottom: 6px;
    text-align: left;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="date"],
input[type="time"],
input[type="password"],
input[type="tel"] {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    background-color: #fdfdfd;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
input[type="time"]:focus,
input[type="password"]:focus,
input[type="tel"]:focus {
    outline: none;
    border-color: #3498db;
}

.checkbox {
    margin-top: 10px;
    transform: scale(1.2);
    accent-color: #3498db;
}

.container .button {
    text-align: center;
    margin-top: 30px;
}

.button button {
    background-color: #3498db;
    color: #fff;
    padding: 12px 26px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button button:hover {
    background-color: #2980b9;
}

@media (max-width: 768px) {
    .container {
        padding: 30px 25px;
    }

    .heading {
        font-size: 28px;
    }
}
.button {
    text-align: center;
    margin-top: 30px;
}

.button button {
    background-color: #3498db;        
    color: #fff;                      
    padding: 12px 26px;               
    font-size: 16px;                 
    font-weight: 600;                 
    border: none;                    
    border-radius: 8px;               
    cursor: pointer;                  
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);  
}

.button button:hover {
    background-color: #2980b9;        
    transform: translateY(-2px);      
}

.button button:active {
    background-color: #2471a3;        
    transform: translateY(0);         
}




    </style>
</head>
<body>
    <script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");


  form.addEventListener("submit", function (e) {
    e.preventDefault(); 

    const formData = new FormData(form);

    fetch("submitForm.php", {
      method: "POST",
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message);

      })
      
  });
});
</script>

</body>
</html>