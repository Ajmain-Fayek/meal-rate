<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  session_destroy();
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $phone = trim($_POST['phone'] ?? '');

  try {
    $phone = trim($_POST['phone'] ?? '');

    if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
      $_SESSION['member_error'] = "Invalid phone number format. Please enter 10-15 digits, optionally starting with +.";
      header("Location: ../components/dashboard/addMember.php");
      exit();
    }

    // Basic validation
    if ($name === '' || $phone === '') {
      throw new Exception("Both Name and Phone are required.");
    }

    // Check if phone already exists in this group
    $stmtCheck = $conn->prepare("SELECT id FROM members WHERE phone = ? AND groupID = ?");
    $stmtCheck->bind_param("si", $phone, $groupID);
    $stmtCheck->execute();
    $existing = $stmtCheck->get_result()->fetch_assoc();
    if ($existing) {
      throw new Exception("A member with this phone number already exists in your group.");
    }

    // Insert new member
    $stmtInsert = $conn->prepare("INSERT INTO members (name, phone, groupID) VALUES (?, ?, ?)");
    $stmtInsert->bind_param("ssi", $name, $phone, $groupID);
    $stmtInsert->execute();

    $_SESSION['member_success'] = "Member '$name' added successfully.";
  } catch (Exception $e) {
    $_SESSION['member_error'] = $e->getMessage();
  }

  // Redirect back to the member page
  header("Location: ./../members.php");
  exit();
}
