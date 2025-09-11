<?php
session_start();
include("../libs/db.php");

// Redirect to login if not authenticated
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}

// Get group ID from session
$group_id = $_SESSION['group_id'];
$group_name = $_SESSION['group_name'];

// Fetch group statistics (you can customize this based on your needs)
$members_count = 0;
$total_deposits = 0;
$total_meals = 0;

$sql = "SELECT COUNT(*) as count FROM Members WHERE GroupID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $group_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
  $members_count = $row['count'];
}

// You can add more queries here to get deposits, meals, etc.
?>

<?php


// Later replace with DB connection
$users = ["Ajmain", "Nobel", "Siddik", "Sabbir", "Faisal"];

// Sample grocery data (to be replaced with database data)
$groceryData = [
  ["date" => "2023-10-15", "note" => "Rice & Vegetables", "amount" => 1250.50],
  ["date" => "2023-10-12", "note" => "Chicken & Spices", "amount" => 980.00],
  ["date" => "2023-10-08", "note" => "Fish & Oil", "amount" => 750.75],
  ["date" => "2023-10-03", "note" => "Fruits & Snacks", "amount" => 620.25],
  ["date" => "2023-09-28", "note" => "Monthly Bulk Purchase", "amount" => 3250.00],
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
  <div class="min-h-[calc(100vh-185px)] flex w-full">
    <!-- Side Bar -->
    <?php
    include("./../components/adminSideBar.php")
    ?>

    <!-- Main container -->
    <div class="p-4 space-y-4 w-full bg-radial-[at_25%_25%] from-purple-100 to-blue-200">

      <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

      <div class="grid grid-cols-1 items-start md:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- Deposit Management -->
        <div class="bg-white shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4">Add Deposit</h2>
          <form action="actions/addDeposit.php" method="POST" class="space-y-3">
            <select name="user" class="w-full border border-gray-400 rounded p-2">
              <?php foreach ($users as $user): ?>
                <option value="<?= $user ?>"><?= $user ?></option>
              <?php endforeach; ?>
            </select>
            <input type="number" name="amount" placeholder="Enter deposit amount" class="w-full border border-gray-400 rounded p-2" required>
            <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2 hover:bg-blue-700">Save</button>
          </form>
        </div>

        <!-- Meal Entry -->
        <div class="bg-white shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4">Add Meal</h2>
          <form action="actions/addMeal.php" method="POST" class="space-y-3">

            <!-- Date -->
            <input type="date" name="date" class="w-full border border-gray-400 rounded p-2" required>

            <!-- Apply to all checkbox -->
            <div class="flex items-center space-x-2">
              <input type="checkbox" id="applyAll" name="apply_all" value="1" class="w-4 h-4 cursor-pointer">
              <label for="applyAll" class="text-gray-700 cursor-pointer">Apply to everyone</label>
            </div>

            <!-- User selection (hidden if apply_all is checked) -->
            <div id="userSelection" class="space-y-2">
              <label class="block text-gray-600 font-medium">Select Members</label>
              <?php foreach ($users as $user): ?>
                <div class="flex items-center space-x-2">
                  <input type="checkbox" id="user_<?= $user ?>" name="selected_users[]" value="<?= $user ?>" class="w-4 h-4 cursor-pointer">
                  <label for="user_<?= $user ?>" class="cursor-pointer"><?= $user ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Meal count -->
            <input type="number" name="meals" placeholder="Number of meals" class="w-full border border-gray-400 rounded p-2" required>

            <!-- Submit -->
            <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2 hover:bg-green-700">Save</button>
          </form>
        </div>

        <script>
          const applyAllCheckbox = document.getElementById("applyAll");
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
        <div class="bg-white shadow-md rounded-xl p-6">
          <h2 class="text-xl font-semibold mb-4">Add Grocery</h2>
          <form action="actions/addGrocery.php" method="POST" class="space-y-3">

            <!-- Date -->
            <input type="date" name="date" class="w-full border border-gray-400 rounded p-2" required>

            <!-- Amount -->
            <input type="number" step="0.01" name="amount" placeholder="Grocery amount" class="w-full border border-gray-400 rounded p-2" required>

            <!-- Short Note -->
            <input type="text" name="note" placeholder="Short note (e.g., Rice, Vegetables)" class="w-full border border-gray-400 rounded p-2" maxlength="100">

            <!-- Submit -->
            <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2 hover:bg-blue-700">Save</button>
          </form>
        </div>

      </div>

      <!-- Grocery History Table -->
      <div class="bg-white shadow-md rounded-xl p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4">Grocery History</h2>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($groceryData as $index => $grocery): ?>
                <tr class="even:bg-gray-100 hover:bg-gray-200">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= date('M j, Y', strtotime($grocery['date'])) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-800"><?= htmlspecialchars($grocery['note']) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= number_format($grocery['amount'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="bg-gray-100">
              <tr>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900" colspan="2">Total</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                  <?= number_format(array_sum(array_column($groceryData, 'amount')), 2) ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>

        <!-- If no grocery data exists -->
        <?php if (empty($groceryData)): ?>
          <div class="text-center py-8 text-gray-500">
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