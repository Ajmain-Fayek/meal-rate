<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $memberID = intval($_POST['id'] ?? 0);

  try {
    if ($memberID <= 0) {
      throw new Exception("Invalid member ID.");
    }

    // Delete member only if belongs to this group
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ? AND groupID = ?");
    $stmt->bind_param("ii", $memberID, $groupID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $_SESSION['member_delete_success'] = "Member deleted successfully.";
    } else {
      throw new Exception("Member not found or does not belong to your group.");
    }

    $stmt->close();
  } catch (Exception $e) {
    $_SESSION['member_delete_error'] = $e->getMessage();
  }

  // Redirect back to members list page
  header("Location: ./../members.php");
  exit();
}
