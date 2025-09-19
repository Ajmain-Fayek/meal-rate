<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include(__DIR__ . "/../../libs/db.php");


// Make sure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../error.php");
  // Destroy the session
  session_destroy();
  exit();
}

$groupID = $_SESSION['group_id']; // logged in group ID

$sql  = "SELECT id, name, phone FROM members WHERE groupID = ? ORDER BY name ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $groupID);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
  $members[] = $row;
}
$stmt->close();
