<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("./../libs/db.php");
include("./dashboardActions/fetchMembers.php");
include("./dashboardActions/addGrocery.php");
include("./dashboardActions/fetchGrocery.php");

// Make sure group is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  // Destroy the session
  session_destroy();

  header("Location: ./../error.php");
  exit();
}

// Default to current month if session not set
if (!isset($_SESSION['month'])) {
  $_SESSION['month'] = date('n');
}

// Update session if user selects a month
if (isset($_GET['statsOfMonth'])) {
  $_SESSION['month'] = (int) $_GET['statsOfMonth'];
}

$selectedMonth = $_SESSION['month'];

// Later replace with DB connection
$users = $members;

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
  <div class="min-h-[calc(100vh-185px)] flex w-full">
    <!-- Side Bar -->
    <?php
    include("./../components/adminSideBar.php")
    ?>

    <!-- Main container -->
    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
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


      <div class="grid grid-cols-1 items-start md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Meal Entry -->
        <div class="bg-green-50 border border-green-600 text-black shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4 text-green-700">Add Meal</h2>
          <form action="./dashboardActions/addMeal.php" method="POST" class="space-y-3">

            <!-- Date -->
            <input type="date" value="<?= date('Y-m-d') ?>" name="mealDate" class="w-full border border-green-400 rounded p-2 outline-0 focus:outline-1 focus:border-green-600 focus:outline-green-600" required>

            <!-- Apply to all checkbox -->
            <div class="flex items-center space-x-2">
              <input type="checkbox" id="mealApplyAll" name="mealApplyAll" value="1" class="w-4 h-4 border cursor-pointer">
              <label for="mealApplyAll" class="cursor-pointer">Apply to everyone</label>
            </div>

            <!-- User selection (hidden if apply_all is checked) -->
            <div id="userSelection" class="space-y-2">
              <label class="block text-green-800 font-medium">Select Members</label>
              <?php foreach ($users as $user): ?>
                <div class="flex items-center space-x-2">
                  <input type="checkbox" id="user_<?= $user['id'] ?>" name="selected_users[]" value="<?= $user['id'] ?>" class="w-4 h-4 cursor-pointer">
                  <label for="user_<?= $user['id'] ?>" class="cursor-pointer"><?= $user['name'] ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Meal count -->
            <input type="number" name="mealCount" placeholder="Number of meals" class="w-full border border-green-400 rounded p-2 outline-0 focus:outline-1 focus:border-green-600 focus:outline-green-600" required>

            <!-- Submit -->
            <button type="submit" class="w-full bg-green-600 text-white font-semibold rounded-lg py-2 hover:bg-green-700 cursor-pointer border-2 border-green-50">Save</button>
          </form>
          <?php if (isset($_SESSION['meal_success'])): ?>
            <div class="mt-3 p-2 bg-green-100 text-green-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['meal_success']) ?>
            </div>
            <?php unset($_SESSION['meal_success']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['meal_error'])): ?>
            <div class="mt-3 p-2 bg-red-100 text-red-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['meal_error']) ?>
            </div>
            <?php unset($_SESSION['meal_error']); ?>
          <?php endif; ?>

        </div>
        <script>
          const applyAllCheckbox = document.getElementById("mealApplyAll");
          const userSelection = document.getElementById("userSelection");

          // Toggle user selection visibility
          applyAllCheckbox.addEventListener("change", () => {
            if (applyAllCheckbox.checked) {
              userSelection.style.display = "none";
            } else {
              userSelection.style.display = "block";
            }
          });
        </script>

        <!-- Grocery Entry -->
        <div class="bg-sky-50 border border-sky-600 text-black shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4 text-sky-800">Add Grocery</h2>
          <form action="./dashboardActions/addGrocery.php" method="POST" class="space-y-3">

            <!-- Date -->
            <input type="date" value="<?= date('Y-m-d') ?>" name="groceryDate" class="w-full border border-sky-400 rounded p-2 outline-0 focus:outline-1 focus:border-sky-600 focus:outline-sky-600" required>

            <!-- Amount -->
            <input type="number" step="0.01" name="groceryAmount" placeholder="Grocery amount" class="w-full border border-sky-400 rounded p-2 outline-0 focus:outline-1 focus:border-sky-600 focus:outline-sky-600" required>

            <!-- Short Note -->
            <input type="text" name="groceryNote" placeholder="Short note (e.g., Rice, Vegetables)" class="w-full border border-sky-400 rounded p-2 outline-0 focus:outline-1 focus:border-sky-600 focus:outline-sky-600" maxlength="100">

            <!-- Submit -->
            <button type="submit" class="w-full bg-sky-600 text-white font-semibold rounded-lg py-2 hover:bg-sky-700 cursor-pointer border-2 border-sky-50">Save</button>
          </form>
          <?php if (isset($_SESSION['grocery_success'])): ?>
            <div class="mt-3 p-2 bg-green-100 text-green-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['grocery_success']) ?>
            </div>
            <?php unset($_SESSION['grocery_success']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['grocery_error'])): ?>
            <div class="mt-3 p-2 bg-red-100 text-red-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['grocery_error']) ?>
            </div>
            <?php unset($_SESSION['grocery_error']); ?>
          <?php endif; ?>

        </div>

        <!-- Deposit Management -->
        <div class="bg-purple-50 border border-purple-600 text-black shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4 text-purple-800">Add Deposit</h2>
          <form action="./dashboardActions/addDeposit.php" method="POST" class="space-y-3">
            <!-- Select a Member Member -->
            <select name="depositUser" class="w-full border bg-purple-50 border-purple-400 rounded p-2 outline-0 focus:outline-1 focus:border-purple-600 focus:outline-purple-600">
              <option value="" disabled selected>Select Member</option>
              <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
              <?php endforeach; ?>
            </select>
            <!-- Date -->
            <input type="date" value="<?= date('Y-m-d') ?>" name="depositDate" class="w-full border border-purple-400 rounded p-2 outline-0 focus:outline-1 focus:border-purple-600 focus:outline-purple-600" required>

            <!-- Amount -->
            <input type="number" name="depositAmount" placeholder="Enter deposit amount" class="w-full border border-purple-400 rounded p-2 outline-0 focus:outline-1 focus:border-purple-600 focus:outline-purple-600" required>
            <button type="submit" class="w-full bg-purple-600 text-white font-semibold rounded-lg py-2 hover:bg-purple-700 cursor-pointer border-2 border-purple-50">Save</button>
          </form>
          <?php if (isset($_SESSION['deposit_success'])): ?>
            <div class="mt-3 p-2 bg-green-100 text-green-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['deposit_success']) ?>
            </div>
            <?php unset($_SESSION['deposit_success']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['deposit_error'])): ?>
            <div class="mt-3 p-2 bg-red-100 text-red-800 rounded shadow">
              <?= htmlspecialchars($_SESSION['deposit_error']) ?>
            </div>
            <?php unset($_SESSION['deposit_error']); ?>
          <?php endif; ?>
        </div>

      </div>

      <!-- Grocery History Table -->
      <div class="bg-red-50 border border-red-600 shadow-md rounded-xl p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4 text-red-800">Grocery History</h2>

        <?php if (!empty($groceryData)): ?>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-red-200">
                <tr class="text-red-800">
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Note</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Amount</th>
                </tr>
              </thead>
              <tbody class="bg-red-100 divide-y divide-gray-200">
                <?php foreach ($groceryData as $index => $grocery): ?>
                  <tr class="even:bg-red-200 hover:bg-red-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= date('M j, Y', strtotime($grocery['date'])) ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800"><?= htmlspecialchars($grocery['note']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= number_format($grocery['amount'], 1) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot class="bg-red-200">
                <tr>
                  <td class="px-6 py-4 text-sm font-semibold text-red-900" colspan="2">Total</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-900">
                    <?= number_format(array_sum(array_column($groceryData, 'amount')), 1) ?>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        <?php endif; ?>

        <!-- If no grocery data exists -->
        <?php if (empty($groceryData)): ?>
          <div class="text-center py-8 text-red-800">
            <p>No grocery data available yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>


  <!-- Footer -->
  <?php
  include("./../components/footer.html")
  ?>
</body>

</html>