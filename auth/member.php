<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Login</title>
  <link rel="stylesheet" href="./../index.css">
</head>

<body>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-2 underline">Meal Rate Login - Member</h2>
      <p class="text-sm text-gray-600 mb-8 text-center">
        Your all-in-one portal for meal tracking.
        View your dashboard, track expenses, and stay updated effortlessly.

      </p>
      <form action="login_process.php" method="post" class="space-y-5">

        <!-- phone -->
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input type="number" id="phone" name="phone" required autofocus
            class="w-full mt-1 px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">
          Login
        </button>
      </form>

      <!-- Register Link -->
      <p class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="register.php" class="font-medium text-blue-600 hover:underline">Register</a>
      </p>

      <!-- Divider -->
      <div class="flex items-center my-2">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="px-3 text-gray-500 text-sm">OR</span>
        <div class="flex-grow border-t border-gray-300"></div>
      </div>

      <!-- Admin login Link -->
      <p class="text-center text-sm text-gray-600">
        Already an Admin of a Group?
        <a href="./login.php" class="font-medium text-green-600 hover:underline">Login</a>
      </p>

      <!-- Divider -->
      <div class="flex items-center my-2">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="px-3 text-gray-500 text-sm">OR</span>
        <div class="flex-grow border-t border-gray-300"></div>
      </div>

      <!-- Return Home Link -->
      <p class="text-center text-sm text-gray-600">
        Return
        <a href="./../index.html" class="font-medium text-purple-600 hover:underline">Home</a>
      </p>

    </div>
  </div>
</body>

</html>