<?php
session_start();
include("./../libs/db.php");
// Make sure Member is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ./../auth/member.php");
  exit();
}
?>

<?php

// Example member data (dynamic later from DB)
$member = [
  "name" => "Ajmain",
  "meals" => 15,
  "deposit" => 2025,
  "lastDeposit" => 100,
  "lastDepositDateTime" => "2025-09-10",
  "balance" => 1234,
  "charge" => 1234,
  "mealRate" => 35.4
];

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
        <form method="GET" action="report.php" class="flex items-center space-x-2">
          <label for="statsOfMonth" class="text-xl font-semibold">Report of</label>
          <select
            name="statsOfMonth"
            id="statsOfMonth"
            class="border border-purple-900 bg-purple-100 rounded-md p-2 font-semibold"
            onchange="this.form.submit()">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
        </form>
      </div>

      <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
        <!-- Header -->
        <div class="px-4 py-3 bg-amber-500">
          <h2 class=" text-lg font-semibold text-center"><?= $_SESSION["member_name"] ?></h2>
        </div>

        <!-- Body -->
        <div class="p-4 space-y-2 text-center">
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Total Meal</span>
            <span class="font-bold"><?= $member["meals"] ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Totoal Deposit</span>
            <span class="font-bold"><?= number_format($member["deposit"], 2) ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Last Deposit</span>
            <span class="font-bold"><?= number_format($member["lastDeposit"], 2) ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Last Deposit Date</span>
            <span class="font-bold"> <?= date('d M Y', strtotime($member["lastDepositDateTime"])) ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Meal Rate</span>
            <span class="font-bold text-blue-600"><?= number_format($member["mealRate"], 2) ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Cost</span>
            <span class="font-bold text-red-600"><?= number_format($member["charge"], 2) ?></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-gray-600">Balance</span>
            <span class="font-bold 
              <?= $member["balance"] >= 0 ? 'text-green-600' : 'text-red-600' ?>">
              <?= number_format($member["balance"], 2) ?>
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