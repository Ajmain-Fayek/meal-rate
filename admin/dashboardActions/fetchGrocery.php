<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Make sure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  session_destroy();
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];
$selectedMonth = $_SESSION['month'] ?? date('n'); // default to current month
$selectedYear  = $_SESSION['year'] ?? date('Y');  // default to current year

// Get first and last day of selected month
$startDate = date('Y-m-01', strtotime("$selectedYear-$selectedMonth-01"));
$endDate   = date('Y-m-t', strtotime($startDate));

$sql  = "SELECT id, purchaseDate as date, note, amount 
         FROM groceries 
         WHERE groupID = ? 
           AND purchaseDate BETWEEN ? AND ?
         ORDER BY purchaseDate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $groupID, $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

$groceryData = [];
while ($row = $result->fetch_assoc()) {
  $groceryData[] = $row;
}
$stmt->close();
