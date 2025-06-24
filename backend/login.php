<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pass = $_POST["password"];
    include_once("./connectToDb.php");
$conn = connect();
    $sql = "select * from users where username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashedFromDb = $user['password'];
        if (password_verify($pass, $hashedFromDb)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] === 'admin') {
                header("location: admin.php");
            exit();

            } elseif ($user['role'] === 'host') {
                header("location: /bernhack/frontend/host.html");
            exit();

            } else {
                header("location: /bernhack/homepage/index.html");
            exit();

            }
        } else {
           echo " $error = incorrect password;";

        }


    } else {
echo " $error=username not found";
    }
}


?>
 