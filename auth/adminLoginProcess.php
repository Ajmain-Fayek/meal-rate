<?php
session_start();
include("../libs/db.php");

// Get form data
$group_name = $_POST['group-name'];
$password = $_POST['password'];

// Validate input
if (empty($group_name) || empty($password)) {
  $_SESSION['login_error'] = "Please fill in all fields";
  header("Location: login.php");
  exit();
}

// Check if group exists and password matches
$sql = "SELECT id, name, password FROM groups WHERE name = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
  $stmt->bind_param("s", $group_name);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $group = $result->fetch_assoc();

    // Verify password (assuming plain text for now)
    if ($password === $group['password']) {
      // Set session variables
      $_SESSION['group_id'] = $group['id'];
      $_SESSION['group_name'] = $group['name'];
      $_SESSION['logged_in'] = true;

      // Redirect to dashboard
      header("Location: ./../admin/dashboard.php");
      exit();
    } else {
      $_SESSION['login_error'] = "Invalid password";
    }
  } else {
    $_SESSION['login_error'] = "Group not found";
  }

  $stmt->close();
} else {
  $_SESSION['login_error'] = "Database error";
}

// If login failed, redirect back to login page
header("Location: login.php");
exit();
