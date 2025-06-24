<?php
session_start();
include_once("./connectToDb.php");
$conn=connect();
if($_SERVER["REQUEST_METHOD"]!=="POST"){
    die("invalid");
}
if(!isset($_POST['event_id'])){
    die("event id not found");
}
$user_id = $_SESSION['user_id']; 
$event_id = $_POST['event_id'];
$now=date('Y-m-d H:i:s');
$submit = $conn->query("INSERT INTO form_submissions(user_id, event_id, submitted_at) VALUES ('$user_id', '$event_id', '$now')");
$submission_id=$conn->insert_id;
$fields=$conn->query("select id,field_type from form_fields where event_id='$event_id'");
if($fields->num_rows === 0){
    die("no fields found");
}
while($field=$fields->fetch_assoc()){
    $field_id=$field['id'];
    $field_type=$field['field_type'];
    $field_name="field_".$field_id;
    if($field_type==="checkbox"){
        $answer=isset($_POST[$field_name])?1:0;

    }
else{
    $answer=$_POST[$field_name];
}
$conn->query("insert into form_answers(submission_id,field_id,answer) values('$submission_id','$field_id','$answer')");

}
echo"succesfully  submitted";
?>