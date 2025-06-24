<?php
session_start();
include_once("./connectToDb.php");
$conn = connect();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to change password.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "New passwords do not match!";
    } else {
        $result = $conn->query("SELECT password FROM users WHERE id = '$user_id'");
      

        if (!password_verify($current_password, $hashed_password)) {
            $message = "Current password is incorrect!";
        } else {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
            if ($update->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error updating password!";
            }
            $update_stmt->close();
        }
    }

}
header("location /bernhack/frontend/login.html");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        form {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            font-family: sans-serif;
        }
        input {
            display: block;
            width: 100%;
            margin: 10px 0 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .message {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Change Password</h2>
        <div class="message"><?= $message ?></div>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Change Password</button>
    </form>
</body>
</html>
