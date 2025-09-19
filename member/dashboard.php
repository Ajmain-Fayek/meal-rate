<?php
session_start();
include("./../libs/db.php");
// Make sure Member is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../auth/member.php");
  exit();
}

include("./actions/fetchMemberStats.php");

// Default to current month if session not set
if (!isset($_SESSION['month'])) {
  $_SESSION['month'] = date('n');
}

// Update session if user selects a month
if (isset($_GET['statsOfMonth'])) {
  $_SESSION['month'] = (int) $_GET['statsOfMonth'];
}

$selectedMonth = $_SESSION['month'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="./../index.css">
</head>

<body>
  <!-- Header -->
  <?php
  include("./../components/navBar.html");
  ?>

  <!-- Body -->
  <div class="min-h-[calc(100vh-185px)] flex">
    <!-- Side Bar -->
    <?php
    include("./../components/memberSideBar.php")
    ?>

    <!-- Main container -->
    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detailed Chart of <span class="text-blue-700"><?= $_SESSION['member_name'] ?></span></h1>
        <!-- Select month to display reports -->
        <!-- Select month to display reports -->
        <form method="GET" action="./dashboard.php" class="flex items-center space-x-2">
          <label for="statsOfMonth" class="text-xl font-semibold">Report of</label>
          <select
            name="statsOfMonth"
            id="statsOfMonth"
            class="border border-purple-900 bg-purple-100 rounded-md p-2 font-semibold"
            onchange="this.form.submit()">
            <?php
            $months = [
              1 => 'January',
              2 => 'February',
              3 => 'March',
              4 => 'April',
              5 => 'May',
              6 => 'June',
              7 => 'July',
              8 => 'August',
              9 => 'September',
              10 => 'October',
              11 => 'November',
              12 => 'December'
            ];

            foreach ($months as $num => $name) {
              $selected = ($num == $selectedMonth) ? 'selected' : '';
              echo "<option value=\"$num\" $selected>$name</option>";
            }
            ?>
          </select>
        </form>
      </div>

      <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
        <!-- Error State -->
        <?php if (isset($_SESSION['memberStats_error'])): ?>
          <div class=" p-2 bg-red-100 text-red-800 rounded shadow">
            <?= htmlspecialchars($_SESSION['memberStats_error']) ?>
          </div>
          <?php unset($_SESSION['memberStats_error']); ?>
        <?php endif; ?>

        <!-- Header -->
        <div class="px-4 py-3 bg-amber-500">
          <h2 class=" text-lg font-semibold text-center"><?= $_SESSION["member_name"] ?></h2>
        </div>

        <!-- Body -->
        <div class="p-4 space-y-2 text-center">
          <!-- Total Meal -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Total Meal</span>
            <span class="font-bold"><?= $memberStats["meals"] ?></span>
          </div>
          <!-- Total Deposit -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Totoal Deposit</span>
            <span class="font-bold"><?= number_format($memberStats["deposit"], 1) ?></span>
          </div>
          <!-- Last Deposit -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Last Deposit</span>
            <span class="font-bold"><?= number_format($memberStats["lastDeposit"], 1) ?></span>
          </div>
          <!-- Last Deposit Date -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Last Deposit Date</span>
            <span class="font-bold"> <?= $memberStats['lastDepositDateTime'] ? date('d M Y', strtotime($memberStats["lastDepositDateTime"])) : "—" ?></span>
          </div>
          <!-- Meal Rate -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Meal Rate</span>
            <span class="font-bold text-blue-600"><?= number_format($memberStats["mealRate"], 1) ?></span>
          </div>
          <!-- Cost -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Cost</span>
            <span class="font-bold text-red-600"><?= number_format($memberStats["charge"], 1) ?></span>
          </div>
          <!-- Balance -->
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Balance</span>
            <span class="font-bold 
              <?= $memberStats["balance"] >= 0 ? 'text-green-600' : 'text-red-600' ?>">
              <?= number_format($memberStats["balance"], 1) ?>
            </span>
          </div>
        </div>
      </div>
    </div>

  </div>


  <!-- Footer -->
  <?php
  include("./../components/footer.html")
  ?>
</body>

</html>