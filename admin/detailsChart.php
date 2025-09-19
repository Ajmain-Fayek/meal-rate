<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("./../libs/db.php");
// Make sure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../auth/login.php");
  exit();
}

include("./detailsActions/fetchMonthDetails.php");
include("./detailsActions/fetchUsersDetails.php");

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
  <title>Details Chart</title>
  <link rel="stylesheet" href="./../index.css">
</head>

<body>
  <!-- Header -->
  <?php
  include("./../components/navBar.html");
  ?>

  <!-- Body -->
  <div class="min-h-[calc(100vh-185px)] flex w-full">
    <!-- Side Bar -->
    <?php
    include("./../components/adminSideBar.php");

    ?>

    <!-- Main container -->

    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Details Chart</h1>
        <!-- Select month to display reports -->
        <form method="GET" action="./detailsChart.php" class="flex items-center space-x-2">
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


      <!-- Cards container -->
      <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-4 gap-6">

        <!-- Totals of Month Card -->
        <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200 2xl:col-span-4 lg:col-span-2">
          <?php if (isset($_SESSION['monthDetails_error'])): ?>
            <div class=" p-2 bg-red-100 text-red-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['monthDetails_error']) ?>
            </div>
            <?php unset($_SESSION['monthDetails_error']); ?>
          <?php endif; ?>

          <div class="px-4 py-3 bg-amber-700">
            <?php
            $monthNum = $_SESSION['month'] ?? date('n'); // default to current month if not set
            $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // Convert month number to name
            ?>
            <h2 class="text-lg font-semibold text-center text-white"><?= htmlspecialchars($monthName) ?> Totals</h2>

          </div>
          <div class="p-4 space-y-2 text-center">
            <div class="flex justify-between">
              <span class="font-medium">Total Meals</span>
              <span class="font-bold"><?= $totalMeals ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Total Deposit</span>
              <span class="font-bold"><?= number_format($totalDeposit, 1) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Total Cost</span>
              <span class="font-bold"><?= number_format($totalCost, 1) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Meal Rate</span>
              <span class="font-bold text-blue-600"><?= number_format($mealRate, 1) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Balance</span>
              <span class="font-bold <?= $balance >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                <?= number_format($balance, 1) ?>
              </span>
            </div>
          </div>
        </div>

        <!-- Individual Cards -->
        <h3 class="text-2xl font-bold text-gray-800 mt-6 2xl:col-span-4 lg:col-span-2">Individual Charts</h3>

        <?php
        // Define your color palette
        $colors = [
          "bg-green-500 text-white",
          "bg-red-500 text-white",
          "bg-yellow-400 text-gray-800",
          "bg-blue-500 text-white",
          "bg-purple-700 text-white",
          "bg-pink-500 text-white",
          "bg-indigo-600 text-white",
        ];

        // Function to assign consistent color per member
        function getColorClass($name, $colors)
        {
          $index = crc32($name) % count($colors);
          return $colors[$index];
        }
        ?>

        <?php foreach ($membersStats as $name => $data): ?>
          <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="px-4 py-3 <?= getColorClass($name, $colors) ?>">
              <h2 class="text-lg font-semibold text-center"><?= htmlspecialchars($name) ?></h2>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-2 text-center">
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Total Meal</span>
                <span class="font-bold"><?= $data["meals"] ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Total Deposit</span>
                <span class="font-bold"><?= number_format($data["deposit"], 1) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Last Deposit</span>
                <span class="font-bold"><?= number_format($data["lastDeposit"], 1) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Last Deposit Date</span>
                <span class="font-bold">
                  <?= $data["lastDepositDateTime"] ? date('d M Y', strtotime($data["lastDepositDateTime"])) : '—' ?>
                </span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Cost</span>
                <span class="font-bold text-blue-600"><?= number_format($data["charge"], 1) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Balance</span>
                <span class="font-bold <?= $data["balance"] >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                  <?= number_format($data["balance"], 1) ?>
                </span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>


  <!-- Footer -->
  <?php
  include("./../components/footer.html")
  ?>
</body>

</html>