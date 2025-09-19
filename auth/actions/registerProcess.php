<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ./register.php");
  exit();
}

try {
  // Collect and sanitize inputs
  $groupName = trim($_POST['groupName'] ?? '');
  $password  = trim($_POST['password'] ?? '');
  $confirmPassword = trim($_POST['confirmPassword'] ?? '');

  // Basic validations
  if (empty($groupName) || empty($password) || empty($confirmPassword)) {
    throw new Exception("All fields are required.");
  }

  if ($password !== $confirmPassword) {
    throw new Exception("Passwords do not match.");
  }

  // Check if group name already exists
  $stmtCheck = $conn->prepare("SELECT id FROM groups WHERE name = ?");
  $stmtCheck->bind_param("s", $groupName);
  $stmtCheck->execute();
  $resultCheck = $stmtCheck->get_result();
  if ($resultCheck->num_rows > 0) {
    throw new Exception("Group name already exists. Choose another name.");
  }
  $stmtCheck->close();

  // Hash the password
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Insert new group
  $stmtInsert = $conn->prepare("INSERT INTO groups (name, password) VALUES (?, ?)");
  $stmtInsert->bind_param("ss", $groupName, $passwordHash);
  $stmtInsert->execute();
  $stmtInsert->close();

  $_SESSION['register_success'] = "Group '$groupName' registered successfully. You can now log in.";
  header("Location: ./../login.php");
  exit();
} catch (Exception $e) {
  $_SESSION['register_error'] = $e->getMessage();
  header("Location: ./../register.php");
  exit();
}
