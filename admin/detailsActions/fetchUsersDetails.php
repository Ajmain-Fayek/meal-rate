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
$mealRate =  $_SESSION['mealRate'];

// Define start and end date of the selected month
$startDate = "$selectedYear-$selectedMonth-01";
$endDate   = date("Y-m-t", strtotime($startDate));

// 2️⃣ Fetch all members in this group
$sqlMembers = "SELECT id, name FROM members WHERE groupID = ?";
$stmt = $conn->prepare($sqlMembers);
$stmt->bind_param("i", $groupID);
$stmt->execute();
$membersResult = $stmt->get_result();
$stmt->close();

$membersStats = [];

while ($member = $membersResult->fetch_assoc()) {
  $memberID = $member['id'];
  $name     = $member['name'];

  // Total Meals of member
  $sqlMeals = "SELECT SUM(mealCount) as totalMeals 
               FROM meals 
               WHERE memberID = ? AND groupID = ? AND mealDate BETWEEN ? AND ?";
  $stmtMeals = $conn->prepare($sqlMeals);
  $stmtMeals->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtMeals->execute();
  $memberTotalMeals = (float) ($stmtMeals->get_result()->fetch_assoc()['totalMeals'] ?? 0);
  $stmtMeals->close();

  // Total Deposit of member
  $sqlDeposit = "SELECT SUM(amount) as totalDeposit 
                 FROM deposits 
                 WHERE memberID = ? AND groupID = ? AND depositDate BETWEEN ? AND ?";
  $stmtDeposit = $conn->prepare($sqlDeposit);
  $stmtDeposit->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtDeposit->execute();
  $memberTotalDeposit = (float) ($stmtDeposit->get_result()->fetch_assoc()['totalDeposit'] ?? 0);
  $stmtDeposit->close();

  // Last Deposit + Last Deposit Date
  $sqlLastDeposit = "SELECT lastDepositAmount, depositDate 
                     FROM deposits 
                     WHERE memberID = ? AND groupID = ? AND depositDate BETWEEN ? AND ?
                     ORDER BY depositDate DESC LIMIT 1";
  $stmtLast = $conn->prepare($sqlLastDeposit);
  $stmtLast->bind_param("iiss", $memberID, $groupID, $startDate, $endDate);
  $stmtLast->execute();
  $lastDepositRow = $stmtLast->get_result()->fetch_assoc();
  $stmtLast->close();

  $lastDeposit      = $lastDepositRow['lastDepositAmount'] ?? 0;
  $lastDepositDate  = $lastDepositRow['depositDate'] ?? null;

  // Cost = meals * mealRate
  $membersCost = $memberTotalMeals * $mealRate;

  // Balance = totalDeposit - cost
  $memberBalance = $memberTotalDeposit - $membersCost;

  $membersStats[$name] = [
    "meals" => $memberTotalMeals,
    "deposit" => $memberTotalDeposit,
    "lastDeposit" => $lastDeposit,
    "lastDepositDateTime" => $lastDepositDate,
    "charge" => $membersCost,
    "balance" => $memberBalance,
  ];
}
