<div class="w-full h-fit mx-auto bg-radial-[at_25%_25%] from-purple-50 to-blue-100 p-6 shadow-md rounded-lg border border-gray-400">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Member</h2>

  <form action="save_member.php" method="POST" class="space-y-5 flex items-center gap-4 w-full">
    <!-- Name -->
    <div class="flex-1">
      <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
      <input type="text" id="name" name="name" required
        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none border-gray-400" />
    </div>

    <!-- Phone -->
    <div class="flex-1">
      <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
      <input type="text" id="phone" name="phone" required
        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none border-gray-400" />
    </div>

    <!-- Submit Button -->
    <button type="submit"
      class="flex-none cursor-pointer active:scale-95 h-fit py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
      Add Member
    </button>
  </form>
</div>