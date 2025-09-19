<?php
session_start();
include("./../libs/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="./../index.css">
</head>

<body>
  <div class="flex items-center justify-center min-h-screen bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-2 underline">Register</h2>
      <p class="text-sm text-gray-600 mb-8 text-center">
        Your all-in-one solution for easy meal management.<br />
        Track, and plan your meals effortlessly.
      </p>
      <form action="actions/registerProcess.php" method="POST" class="space-y-5">

        <!-- Group Name -->
        <div>
          <label for="groupName" class="block text-sm font-medium text-gray-700">Group Name
            <br />
            <span class="text-red-500 font-normal">*Case-sensitive! This will use as username for login</span>
          </label>
          <input type="text" id="groupName" name="groupName" required
            placeholder="Ex: Engineers-Home"
            class="w-full mt-1 px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300" />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" required
              placeholder="Password"
              class="w-full mt-1 px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300 pr-10" />

            <!-- Toggle Button -->
            <button type="button" id="togglePassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
              <!-- Eye Icon -->
              <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                   8.268 2.943 9.542 7-1.274 4.057-5.065 
                   7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <!-- Eye Slash Icon (hidden by default) -->
              <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                   0-8.268-2.943-9.542-7a9.97 9.97 0 
                   012.223-3.592M6.223 6.223A9.969 9.969 
                   0 0112 5c4.477 0 8.268 2.943 9.542 
                   7a9.97 9.97 0 01-4.132 5.411M15 
                   12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3l18 18" />
              </svg>
            </button>
          </div>
        </div>
        <!-- Confirm Password -->
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <div class="relative">
            <input type="password" id="confirmPassword" name="confirmPassword" required
              placeholder="Re-type Password"
              class="w-full mt-1 px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300 pr-10" />
          </div>
        </div>

        <!-- Script for password toggle -->
        <script>
          const passwordInput = document.getElementById("password");
          const togglePassword = document.getElementById("togglePassword");
          const eyeOpen = document.getElementById("eyeOpen");
          const eyeClosed = document.getElementById("eyeClosed");

          togglePassword.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            eyeOpen.classList.toggle("hidden", !isPassword);
            eyeClosed.classList.toggle("hidden", isPassword);
          });
        </script>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">
          Register
        </button>
      </form>
      <?php if (isset($_SESSION['register_error'])): ?>
        <div class="mt-3 p-2 bg-red-100 text-red-800 rounded shadow">
          <?= htmlspecialchars($_SESSION['register_error']) ?>
        </div>
        <?php unset($_SESSION['register_error']); ?>
      <?php endif; ?>

      <!-- Admin Login Link -->
      <p class="mt-6 text-center text-sm text-gray-600">
        Already an Admin of a Group?
        <a href="login.php" class="font-medium text-blue-600 hover:underline">Login</a>
      </p>

      <!-- Divider -->
      <div class="flex items-center my-2">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="px-3 text-gray-500 text-sm">OR</span>
        <div class="flex-grow border-t border-gray-300"></div>
      </div>

      <!-- Member Dashboard Link -->
      <p class="text-center text-sm text-gray-600">
        Already a member of a Group?
        <a href="./member.php" class="font-medium text-green-600 hover:underline">Login to Dashboard</a>
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