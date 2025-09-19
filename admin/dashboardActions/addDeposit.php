<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include(__DIR__ . "/../../libs/db.php");

// Ensure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../error.php");
  exit();
}

$groupID = $_SESSION['group_id'];
$selectedMonth = $_SESSION['month']; // month chosen for stats
$selectedYear = $_SESSION['year'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $memberID    = intval($_POST['depositUser'] ?? 0);
  $amount      = floatval($_POST['depositAmount'] ?? 0);
  $depositDate = $_POST['depositDate'] ?? date('Y-m-d');

  try {
    if ($memberID <= 0 || $amount <= 0) {
      throw new Exception("Please select a valid member and enter a positive amount.");
    }

    $depositMonth = (int) date('n', strtotime($depositDate));
    $depositYear  = (int) date('Y', strtotime($depositDate));

    // Check if deposit date is within the selected month/year
    if ($depositMonth !== (int)$selectedMonth || $depositYear !== (int)$selectedYear) {
      throw new Exception("Deposit date must be within the selected month (" . date('F Y', strtotime("$selectedYear-$selectedMonth-01")) . ").");
    }

    // Fetch member name
    $stmtMember = $conn->prepare("SELECT name FROM members WHERE id = ? AND groupID = ?");
    $stmtMember->bind_param("ii", $memberID, $groupID);
    $stmtMember->execute();
    $memberRow = $stmtMember->get_result()->fetch_assoc();
    if (!$memberRow) throw new Exception("Selected member not found in this group.");
    $memberName = $memberRow['name'];

    // Month start and end dates
    $startMonth = date('Y-m-01', strtotime($depositDate));
    $endMonth   = date('Y-m-t', strtotime($depositDate));

    // Check if deposit exists for this month
    $stmtCheck = $conn->prepare("
            SELECT id, amount 
            FROM deposits 
            WHERE memberID = ? AND groupID = ? AND depositDate BETWEEN ? AND ? 
            LIMIT 1
        ");
    $stmtCheck->bind_param("iiss", $memberID, $groupID, $startMonth, $endMonth);
    $stmtCheck->execute();
    $existing = $stmtCheck->get_result()->fetch_assoc();

    if ($existing) {
      // Update existing deposit
      $newAmount = $existing['amount'] + $amount;
      $stmtUpdate = $conn->prepare("
                UPDATE deposits 
                SET amount = ?, lastDepositAmount = ?, depositDate = ?, addedAt = NOW() 
                WHERE id = ?
            ");
      $stmtUpdate->bind_param("ddsi", $newAmount, $amount, $depositDate, $existing['id']);
      $stmtUpdate->execute();

      $_SESSION['deposit_success'] = "Deposit updated: $amount added to $memberName for " . date('F Y', strtotime($depositDate)) . " (Total: $newAmount)";
    } else {
      // Insert new deposit
      $stmtInsert = $conn->prepare("
                INSERT INTO deposits (memberID, amount, depositDate, lastDepositAmount, groupID) 
                VALUES (?, ?, ?, ?, ?)
            ");
      $stmtInsert->bind_param("idsdi", $memberID, $amount, $depositDate, $amount, $groupID);
      $stmtInsert->execute();

      $_SESSION['deposit_success'] = "Deposit of $amount added successfully for $memberName on $depositDate.";
    }
  } catch (Exception $e) {
    $_SESSION['deposit_error'] = $e->getMessage();
  }

  header("Location: ./../dashboard.php");
  exit();
}
