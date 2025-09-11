<?php
// Sample members data (replace with DB query later)
$members = [
  ["id" => 1, "name" => "John Doe", "phone" => "123-456-7890"],
  ["id" => 2, "name" => "Jane Smith", "phone" => "987-654-3210"],
  ["id" => 3, "name" => "Ali Hasan", "phone" => "555-123-4567"],
];
?>

<div class="mx-auto bg-white p-6 shadow-md rounded-lg border border-gray-200 h-fit w-full">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Members List</h2>

  <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 border-b">#</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 border-b">Name</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 border-b">Phone</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 border-b">Action</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      <?php foreach ($members as $index => $member): ?>
        <tr class="hover:bg-gray-200 odd:bg-white even:bg-gray-50">
          <td class="px-6 py-3 text-sm text-gray-700"><?= $index + 1 ?></td>
          <td class="px-6 py-3 text-sm text-gray-700"><?= htmlspecialchars($member['name']) ?></td>
          <td class="px-6 py-3 text-sm text-gray-700"><?= htmlspecialchars($member['phone']) ?></td>
          <td class="px-6 py-3">
            <form action="delete_member.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');">
              <input type="hidden" name="id" value="<?= $member['id'] ?>">
              <button type="submit"
                class="bg-red-500 active:scale-95 cursor-pointer text-white px-3 py-1 rounded-md hover:bg-red-600 transition text-sm">
                Delete
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>