<?php
// Set default values
$errorCode = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : 'Error';
$errorMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'An unexpected error occurred.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error <?php echo $errorCode; ?></title>
  <link rel="stylesheet" href="./index.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-radial-[at_25%_25%] from-purple-100 to-blue-200">

  <div class="min-h-screen flex flex-col items-center justify-center">
    <div class="text-center p-8">
      <h1 class="text-9xl font-bold text-indigo-600"><?php echo $errorCode; ?></h1>

      <h2 class="mt-4 text-4xl font-semibold text-gray-800">Internal Server Error</h2>

      <p class="mt-2 text-lg text-gray-600">
        <?php echo $errorMessage; ?>
      </p>

      <div class="mt-8">
        <a href="/mealRate" class="px-6 py-3 text-lg font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-colors duration-200">
          Return Home
        </a>
      </div>
    </div>
  </div>

</body>

</html>