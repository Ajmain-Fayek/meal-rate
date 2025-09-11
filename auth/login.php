<?php
session_start();
include("./../libs/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Meal Rate - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./../index.css">
</head>

<body>
  <div class="flex items-center justify-center min-h-screen bg-radial-[at_25%_25%] from-purple-100 to-blue-200">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-2 underline">Meal Rate Login - Group Admin</h2>
      <p class="text-sm text-gray-600 mb-8 text-center">
        Your central hub for meal system administration.
        Manage users, track activities, and oversee operations with ease.

      </p>

      <?php if (isset($_SESSION["login_error"]) && $_SESSION["login_error"]): ?>
        <p class="p-2 mb-4 text-center rounded-lg bg-red-100 text-red-700 border border-red-600">
          <?php echo $_SESSION["login_error"]; ?>
        </p>
      <?php endif; ?>

      <form action="login_process.php" method="post" class="space-y-5">

        <!-- Group Name -->
        <div>
          <label for="group-name" class="block text-sm font-medium text-gray-700">Group Name</label>
          <input type="text" id="group-name" name="group-name" required
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