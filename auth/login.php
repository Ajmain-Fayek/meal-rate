<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Meal Rate - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; }
    .login-container {
      max-width: 350px;
      margin: 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; margin-bottom: 24px; }
    label { display: block; margin-bottom: 6px; }
    input[type="text"], input[type="password"] {
      width: 100%; padding: 8px; margin-bottom: 16px;
      border: 1px solid #ccc; border-radius: 4px;
    }
    button {
      width: 100%; padding: 10px;
      background: #28a745; color: #fff;
      border: none; border-radius: 4px;
      font-size: 16px; cursor: pointer;
    }
    button:hover { background: #218838; }
    .register-link {
      text-align: center;
      margin-top: 16px;
      font-size: 15px;
    }
    .register-link a {
      color: #007bff;
      text-decoration: none;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Meal Rate Login</h2>
    <form action="login_process.php" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
    <div class="register-link">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>