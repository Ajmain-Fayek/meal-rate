<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];
$selectedMonth = $_SESSION['month'] ?? date('n'); // 1-12
$selectedYear  = $_SESSION['year'] ?? date('Y');
$totalMeals = 0.0;
$totalDeposit = 0.0;
$totalCost = 0.0;
$mealRate = 0.0;
$balance = 0.0;

// Define start and end date of the selected month
$startDate = "$selectedYear-$selectedMonth-01";
$endDate   = date("Y-m-t", strtotime($startDate)); // last day of month

try {
  // 1️⃣ Total Meals
  $sqlMeals = "SELECT SUM(mealCount) as totalMeals 
               FROM meals 
               WHERE groupID = ? AND mealDate BETWEEN ? AND ?";
  $stmtMeals = $conn->prepare($sqlMeals);
  $stmtMeals->bind_param("iss", $groupID, $startDate, $endDate);
  $stmtMeals->execute();
  $totalMeals   = (float) ($stmtMeals->get_result()->fetch_assoc()['totalMeals'] ?? 0);
  $stmtMeals->close();

  // 2️⃣ Total Deposit
  $sqlDeposit = "SELECT SUM(amount) as totalDeposit 
                 FROM deposits 
                 WHERE groupID = ? AND depositDate BETWEEN ? AND ?";
  $stmtDeposit = $conn->prepare($sqlDeposit);
  $stmtDeposit->bind_param("iss", $groupID, $startDate, $endDate);
  $stmtDeposit->execute();
  $totalDeposit = (float) ($stmtDeposit->get_result()->fetch_assoc()['totalDeposit'] ?? 0);
  $stmtDeposit->close();

  // 3️⃣ Total Cost (Grocery)
  $sqlGrocery = "SELECT SUM(amount) as totalCost 
                 FROM groceries 
                 WHERE groupID = ? AND purchaseDate BETWEEN ? AND ?";
  $stmtGrocery = $conn->prepare($sqlGrocery);
  $stmtGrocery->bind_param("iss", $groupID, $startDate, $endDate);
  $stmtGrocery->execute();
  $totalCost    = (float) ($stmtGrocery->get_result()->fetch_assoc()['totalCost'] ?? 0);
  $stmtGrocery->close();

  // 4️⃣ Meal Rate
  $mealRate = ($totalMeals > 0) ? ($totalCost / $totalMeals) : 0;
  $_SESSION['mealRate'] = $mealRate;

  // 5️⃣ Balance
  $balance = $totalDeposit - $totalCost;

  $_SESSION['monthDetails_success'] = "Month details Fetched";
} catch (Exception $e) {
  // ✅ Error message
  $_SESSION['monthDetails_error'] = $e->getMessage();
}
