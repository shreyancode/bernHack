<?php
include_once("./connectToDb.php");

$conn = connect();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    if (strlen($pass) < 8) {

        echo "password length should be greater than 8";
        exit();
    } else {
        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            echo "Username is already taken.";
        }


        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username,email,password) VALUES('$username','$email','$hashed_password')";
        $result = $conn->query($sql);

        header("Location: login.php");
        exit();

    }
}
?>