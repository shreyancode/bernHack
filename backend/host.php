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
            $label = $conn->real_escape_string($labels[$i]);
            $type = $conn->real_escape_string($types[$i]);
            $is_required = isset($is_reqs[$i]) ? 1 : 0;

            $conn->query("INSERT INTO form_fields(event_id, label, field_type, is_req)
                          VALUES('$event_id', '$label', '$type', '$is_required')");
        }
    }

    echo "Event and custom form fields created!";
}


?>


<form action="create_event.php" method="POST">
    <input type="text" name="title" placeholder="Event Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <input type="text" name="location" placeholder="Location" required>

    <h3>Custom Form Fields</h3>
    <div id="custom-fields"></div>
    <button type="button" onclick="addField()">+ Add Field</button>

    <br><br>
    <button type="submit">Create Event</button>
</form>

<script>
let fieldCount = 0;

function addField() {
    const container = document.getElementById("custom-fields");
    const div = document.createElement('div');
    div.classList.add('field-group');

    div.innerHTML = `
        <input type="text" name="labels[]" placeholder="Label (e.g. Full Name)" required>
        <select name="types[]" required>
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
            <option value="checkbox">Checkbox</option>
        </select>
        <label>
            Required?
            <input type="checkbox" name="is_req[${fieldCount}]">
        </label>
        <button type="button" onclick="this.parentElement.remove()">🗑 Remove</button>
        <br><br>
    `;
    container.appendChild(div);
    fieldCount++;
}
</script>
