<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Get form data
$phone = $_POST['phone'];

// Validate input
if (empty($phone)) {
  $_SESSION['login_error'] = "Please fill in all fields";
  header("Location: member.php");
  exit();
}

// Check if group exists and password matches
$sql = "SELECT id, phone, name, groupID FROM members WHERE phone = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
  $stmt->bind_param("s", $phone);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $member = $result->fetch_assoc();

    // Verify password (assuming plain text for now)
    if ($phone === $member['phone']) {
      // Set session variables
      $_SESSION['member_id'] = $member['id'];
      $_SESSION['member_name'] = $member['name'];
      $_SESSION['group_id'] = $member['groupID'];
      $_SESSION['logged_in'] = true;
      $_SESSION['month'] = date('n');
      $_SESSION['year'] = date('Y');

      // Redirect to dashboard
      header("Location: ./../../member/dashboard.php");
      exit();
    } else {
      $_SESSION['login_error'] = "Invalid Phone";
    }
  } else {
    $_SESSION['login_error'] = "Member not found";
  }

  $stmt->close();
} else {
  $_SESSION['login_error'] = "Database error";
}

// If login failed, redirect back to login page
header("Location: ./../member.php");
exit();
