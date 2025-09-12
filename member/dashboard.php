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
    include("./../components/memberSideBar.html")
    ?>

    <!-- Main container -->
    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
      <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
        <!-- Header -->
        <div class="px-4 py-3 bg-amber-500">
          <h2 class=" text-lg font-semibold text-center"><?= $member["name"] ?></h2>
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