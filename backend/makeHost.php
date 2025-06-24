<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: /bernhack/frontend/login.html");
  exit();
}
include_once("./connectToDb.php");
$conn = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 'host';

  
    $result = $conn->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')");
  

    
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create New Host</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f7fc;
      padding: 50px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    form {
      max-width: 400px;
      margin: auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    label {
      font-weight: 500;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      color: #444;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background-color: rgb(131, 164, 255);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color:rgb(131, 164, 255);
    }

    .message {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .message.success {
      color: green;
    }

    .message.error {
      color: red;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #007BFF;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <h2>Create New Host Account</h2>

  

  <form method="POST" action="">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit" onclick="message()">Create Host</button>
  </form>

  <a href="/bernhack/frontend/admin1.html"> Back to Admin Panel</a>
<script>
function message(){
  alert("host created");
}
</script>
</body>
</html>
