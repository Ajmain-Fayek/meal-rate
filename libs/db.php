<?php
// --- Step 1: Tell MySQLi to throw exceptions on errors ---
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mealdb";
$conn = null; // Initialize conn as null

try {
  $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {

  $errorCode = 500;

  $errorMessage = "A database error occurred. Please try again later.";

  header("Location: ./../error.php?code=" . $errorCode . "&message=" . urlencode($errorMessage));
  exit();
}
