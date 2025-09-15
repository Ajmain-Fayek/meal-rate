<?php

// Meal rate (can come from DB/config)
$mealRate = 35.5;

// Example member data (dynamic later from DB)
$members = [
  "Ajmain" => [
    "meals" => 15,
    "deposit" => 2025,
    "lastDeposit" => 100,
    "lastDepositDateTime" => "2025-09-10"
  ],
  "Nobel"  => [
    "meals" => 10,
    "deposit" => -71,
    "lastDeposit" => 100,
    "lastDepositDateTime" => "2025-09-09"
  ],
  "Siddik" => [
    "meals" => 10,
    "deposit" => 1423,
    "lastDeposit" => 100,
    "lastDepositDateTime" => "2025-09-08"
  ],
  "Sabbir" => [
    "meals" => 10,
    "deposit" => 518,
    "lastDeposit" => 100,
    "lastDepositDateTime" => "2025-09-07"
  ],
  "Faisal" => [
    "meals" => 10,
    "deposit" => 1000,
    "lastDeposit" => 100,
    "lastDepositDateTime" => "2025-09-06"
  ],
];


// Calculate charges & balances
foreach ($members as $name => $data) {
  $charge = $mealRate * $data["meals"];
  $balance = $data["deposit"] - $charge;
  $members[$name]["charge"] = $charge;
  $members[$name]["balance"] = $balance;
}

// Totals
$totalMeals = 0;
$totalDeposit = 0;
$totalCost = 0;
$totalBalance = 0;

foreach ($members as $data) {
  $totalMeals   += $data["meals"];
  $totalDeposit += $data["deposit"];
  $totalCost    += $data["charge"];
  $totalBalance += $data["balance"];
}

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
    include("./../components/adminSideBar.php")
    ?>

    <!-- Main container -->
    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Details Chart</h1>
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


      <!-- Cards container -->
      <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-4 gap-6">

        <!-- Totals of Month Card -->
        <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200 2xl:col-span-4 lg:col-span-2">
          <div class="px-4 py-3 bg-amber-700">
            <h2 class="text-lg font-semibold text-center text-white">September Totals</h2>
          </div>
          <div class="p-4 space-y-2 text-center">
            <div class="flex justify-between">
              <span class="font-medium">Total Meals</span>
              <span class="font-bold"><?= $totalMeals ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Total Deposit</span>
              <span class="font-bold"><?= number_format($totalDeposit, 2) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Total Cost</span>
              <span class="font-bold"><?= number_format($totalCost, 2) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Meal Rate</span>
              <span class="font-bold text-blue-600"><?= number_format($mealRate, 2) ?></span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium">Balance</span>
              <span class="font-bold <?= $totalBalance >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                <?= number_format($totalBalance, 2) ?>
              </span>
            </div>
          </div>
        </div>

        <!-- Individual Cards -->
        <h3 class="text-2xl font-bold text-gray-800 mt-6 2xl:col-span-4 lg:col-span-2">Individual Charts</h3>

        <?php foreach ($members as $name => $data): ?>
          <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="px-4 py-3 
          <?php if ($name === 'Ajmain') echo 'bg-green-500 text-white';
          elseif ($name === 'Nobel') echo 'bg-red-500 text-white';
          elseif ($name === 'Siddik') echo 'bg-yellow-400 text-gray-800';
          elseif ($name === 'Sabbir') echo 'bg-blue-500 text-white';
          elseif ($name === 'Faisal') echo 'bg-purple-700 text-white'; ?>">
              <h2 class="text-lg font-semibold text-center"><?= $name ?></h2>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-2 text-center">
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Total Meal</span>
                <span class="font-bold"><?= $data["meals"] ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Totoal Deposit</span>
                <span class="font-bold"><?= number_format($data["deposit"], 2) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Last Deposit</span>
                <span class="font-bold"><?= number_format($data["lastDeposit"], 2) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Last Deposit Date</span>
                <span class="font-bold"> <?= date('d M Y', strtotime($data["lastDepositDateTime"])) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Cost</span>
                <span class="font-bold text-blue-600"><?= number_format($data["charge"], 2) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="font-medium text-gray-600">Balance</span>
                <span class="font-bold 
              <?= $data["balance"] >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                  <?= number_format($data["balance"], 2) ?>
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