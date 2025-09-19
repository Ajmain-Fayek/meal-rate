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
  $mealDate  = $_POST['mealDate'] ?? date('Y-m-d');
  $mealCount = (int) ($_POST['mealCount'] ?? 1);
  $addedMembers = [];

  try {
    // Validate meal count
    if ($mealCount <= 0) {
      throw new Exception("Meal count must be at least 1.");
    }

    // Check if mealDate is within selected month/year
    $mealMonth = (int) date('n', strtotime($mealDate));
    $mealYear  = (int) date('Y', strtotime($mealDate));

    if ($mealMonth !== (int)$selectedMonth || $mealYear !== (int)$selectedYear) {
      throw new Exception("Meal date must be within the selected month (" . date('F Y', strtotime("$selectedYear-$selectedMonth-01")) . ").");
    }

    // Apply to all members
    if (isset($_POST['mealApplyAll']) && $_POST['mealApplyAll'] == 1) {
      $sqlUsers = "SELECT id, name FROM members WHERE groupID = ?";
      $stmt     = $conn->prepare($sqlUsers);
      $stmt->bind_param("i", $groupID);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
        throw new Exception("No members found in this group.");
      }

      while ($row = $result->fetch_assoc()) {
        $memberID = $row['id'];
        $addedMembers[] = $row['name'];

        $sqlInsert = "INSERT INTO meals (memberID, groupID, mealDate, mealCount)
                              VALUES (?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iisi", $memberID, $groupID, $mealDate, $mealCount);
        $stmtInsert->execute();
      }

      // Apply to selected members
    } elseif (!empty($_POST['selected_users'])) {
      foreach ($_POST['selected_users'] as $memberID) {
        $sqlGetName = "SELECT name FROM members WHERE id = ? AND groupID = ?";
        $stmtName = $conn->prepare($sqlGetName);
        $stmtName->bind_param("ii", $memberID, $groupID);
        $stmtName->execute();
        $row = $stmtName->get_result()->fetch_assoc();

        if (!$row) {
          throw new Exception("Member with ID $memberID not found in your group.");
        }

        $addedMembers[] = $row['name'];

        $sqlInsert = "INSERT INTO meals (memberID, groupID, mealDate, mealCount)
                              VALUES (?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iisi", $memberID, $groupID, $mealDate, $mealCount);
        $stmtInsert->execute();
      }
    } else {
      throw new Exception("Please select at least one member or apply to everyone.");
    }

    // ✅ Success message
    $names = implode(', ', $addedMembers);
    $_SESSION['meal_success'] = "$mealCount meal(s) added for: $names";
  } catch (Exception $e) {
    // ✅ Error message
    $_SESSION['meal_error'] = $e->getMessage();
  }

  header("Location: ./../dashboard.php");
  exit();
}
