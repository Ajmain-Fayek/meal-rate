<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  session_destroy();
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];
$selectedMonth = $_SESSION['month'] ?? date('n'); // default current month
$selectedYear  = $_SESSION['year'] ?? date('Y');  // default current year

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $purchaseDate = $_POST['groceryDate'] ?? date('Y-m-d');
  $amount       = (float) ($_POST['groceryAmount'] ?? 0);
  $note         = $_POST['groceryNote'] ?? '';

  try {
    // Validate amount
    if ($amount <= 0) {
      throw new Exception("Please enter a valid grocery amount.");
    }

    // Check if purchaseDate is within selected month/year
    $purchaseMonth = (int) date('n', strtotime($purchaseDate));
    $purchaseYear  = (int) date('Y', strtotime($purchaseDate));

    if ($purchaseMonth !== (int)$selectedMonth || $purchaseYear !== (int)$selectedYear) {
      throw new Exception("Purchase date must be within the selected month (" . date('F Y', strtotime("$selectedYear-$selectedMonth-01")) . ").");
    }

    // Insert grocery record
    $sql = "INSERT INTO groceries (groupID, purchaseDate, amount, note) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $groupID, $purchaseDate, $amount, $note);
    $stmt->execute();

    $_SESSION['grocery_success'] = "Grocery added successfully: $amount on $purchaseDate";
  } catch (Exception $e) {
    $_SESSION['grocery_error'] = $e->getMessage();
  }

  header("Location: ./../dashboard.php");
  exit();
}
