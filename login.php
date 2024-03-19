<?php
session_start();

// Include your database connection and configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password (you should have a similar hashing method in your registration process)
    $hashed_password = md5($password);

    // Prepare and execute the SQL query to check user credentials
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user with the given credentials exists, redirect to admin page
    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username; // Store username in session
        header("Location: admin.php"); // Redirect to admin page
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperShop Management - Login</title>
<link rel="stylesheet" href="styles.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="Wrapper">
  <form action="">
   <h1>Login</h1> 
   <div class="input_box">
    <input type="text" placeholder="Username"required>
    <i class='bx bxs-user'></i>

   </div>
   <div class="input_box">
    <input type="text" placeholder="Password"required>
    <i class='bx bxs-lock-alt'></i>
    
   </div>
   <div class="remember-forgot">
    <label><input type = "checkbox">Remember me </label>
    <a href = "#">Forgot password?</a> 

   </div>
   <button type="submit"class="btn">Login</button>
   <div class="register-link">
    <p>Don't have an account? <a href="#">Register</a></p>
   </div>
  </form>
 
</div>