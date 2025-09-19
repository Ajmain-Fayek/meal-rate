<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../../error.php");
  exit();
}

$groupID       = $_SESSION['group_id'];
$selectedMonth = $_SESSION['month'] ?? date('n'); // default to current month
$selectedYear  = $_SESSION['year'] ?? date('Y');
$memberID      = $_SESSION['member_id'] ?? 0; // Pass member ID via GET
$memberName    = $_SESSION['member_name'] ?? 0; // Pass member ID via GET

if (!$memberID) {
  die("Invalid member ID.");
}

// Define start and end dates for the month
$startDate = "$selectedYear-$selectedMonth-01";
$endDate   = date("Y-m-t", strtotime($startDate));

try {
  // 1️⃣ Total Meals for the member
  $sqlMeals = "SELECT SUM(mealCount) as totalMeals 
                 FROM meals 
                 WHERE memberID = ? AND groupID = ? AND mealDate BETWEEN ? AND ?";
  $stmtMeals = $conn->prepare($sqlMeals);
  $stmtMeals->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtMeals->execute();
  $totalMeals = (float) ($stmtMeals->get_result()->fetch_assoc()['totalMeals'] ?? 0);
  $stmtMeals->close();

  // 2️⃣ Total Deposit for the member
  $sqlDeposit = "SELECT SUM(amount) as totalDeposit 
                   FROM deposits 
                   WHERE memberID = ? AND groupID = ? AND depositDate BETWEEN ? AND ?";
  $stmtDeposit = $conn->prepare($sqlDeposit);
  $stmtDeposit->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtDeposit->execute();
  $totalDeposit = (float) ($stmtDeposit->get_result()->fetch_assoc()['totalDeposit'] ?? 0);
  $stmtDeposit->close();

  // 3️⃣ Last Deposit info
  $sqlLastDeposit = "SELECT lastDepositAmount, depositDate 
                       FROM deposits 
                       WHERE memberID = ? AND groupID = ? AND depositDate BETWEEN ? AND ? 
                       ORDER BY depositDate DESC LIMIT 1";
  $stmtLast = $conn->prepare($sqlLastDeposit);
  $stmtLast->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtLast->execute();
  $lastDepositRow = $stmtLast->get_result()->fetch_assoc();
  $lastDepositAmount = (float) ($lastDepositRow['lastDepositAmount'] ?? 0);
  $lastDepositDateTime = $lastDepositRow['depositDate'] ?? null;
  $stmtLast->close();

  // 4️⃣ Group Total Meals for mealRate calculation
  $sqlGroupMeals = "SELECT SUM(mealCount) as groupMeals 
                      FROM meals 
                      WHERE groupID = ? AND mealDate BETWEEN ? AND ?";
  $stmtGroupMeals = $conn->prepare($sqlGroupMeals);
  $stmtGroupMeals->bind_param("iss", $groupID, $startDate, $endDate);
  $stmtGroupMeals->execute();
  $groupMeals = (float) ($stmtGroupMeals->get_result()->fetch_assoc()['groupMeals'] ?? 0);
  $stmtGroupMeals->close();

  // 5️⃣ Total Grocery Cost for the month
  $sqlGrocery = "SELECT SUM(amount) as totalCost 
                   FROM groceries 
                   WHERE groupID = ? AND purchaseDate BETWEEN ? AND ?";
  $stmtGrocery = $conn->prepare($sqlGrocery);
  $stmtGrocery->bind_param("iss", $groupID, $startDate, $endDate);
  $stmtGrocery->execute();
  $totalCost = (float) ($stmtGrocery->get_result()->fetch_assoc()['totalCost'] ?? 0);
  $stmtGrocery->close();

  // 6️⃣ Meal Rate
  $mealRate = ($groupMeals > 0) ? ($totalCost / $groupMeals) : 0;

  // 7️⃣ Member Charge
  $charge = $totalMeals * $mealRate;

  // 8️⃣ Balance
  $balance = $totalDeposit - $charge;

  // Prepare the final stats array
  $memberStats = [
    "name" => $memberName,
    "meals" => $totalMeals,
    "deposit" => $totalDeposit,
    "lastDeposit" => $lastDepositAmount,
    "lastDepositDateTime" => $lastDepositDateTime,
    "charge" => $charge,
    "mealRate" => $mealRate,
    "balance" => $balance
  ];
  $_SESSION['memberStats_success'] = "Month details Fetched";
} catch (Exception $e) {
  // ✅ Error message
  $_SESSION['memberStats_error'] = $e->getMessage();
}
