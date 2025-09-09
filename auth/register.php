<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <style>
    body { font-family: Arial, sans-serif; }
    .container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
    label { display: block; margin-top: 10px; }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box;
    }
    button { margin-top: 15px; padding: 10px 20px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Register</h2>
    <form action="register_process.php" method="POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>