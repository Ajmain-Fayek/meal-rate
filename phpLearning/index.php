<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <!-- <form action="index.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Submit">
  </form> -->

  <!-- Some Math functions -->
   <form action="index.php" method="get">
    <label>Insert Number:</label>
    <input type="text" name="number">
    <br>
    <label>Insert Number1:</label>
    <input type="text" name="number1">
    <br>
    <label>Insert Number2:</label>
    <input type="text" name="number2">
    <br>
    <input type="submit" value="Submit">
   </form>
  
</body>
</html>

<?php
 // Variables
 // $<variable-name> = <value>
//  $x = "Hello world!";
//  $y = 1234;

 // Print
//  echo "$x <br> $y";

/** =================================================================== */

/**
 *  Get form data from HTML (not secure)
 *  $_GET["<value of name attrubute>"] global varibale
 *  embeds value into the url
 *  index.php?username=devAjmain&password=dsfsdf */

//  $username = $_GET["username"];
//  $password = $_GET["password"];
//  echo "username: {$username} <br> password: {$password}";

/** =================================================================== */

/**
 * Get form data form HTML form (secure)
 *  Does not embeds values into the url
 * $_POST["<value of name attribute>"] global varibale */ 

// $username1 = $_POST["username"];
// $password1 = $_POST["password"];
//  echo "username: {$username1} <br> password: {$password1}";

/** ==================================================================== */

/**
 * Some math functions to explore
 */

// $number = $_GET["number"];
// $number1 = $_GET["number1"];
// $number2 = $_GET["number2"];

// abs() returns absolute/positive value
// $absolute = abs($number);
// echo "absolute value: {$absolute} <br>";

// round() returns rounded numbers (if decimal is < 0.5 then number floor, if decimal is >= 0.5 then number ceils)
// $round = round($number);
// echo "Rounded: {$round} <br>";

// floor()
// $floor = floor($number);
// echo "Floor: {$floor} <br>";

// ceil()
// $ceil = ceil($number);
// echo "Ceil: {$ceil} <br>";

// pow(<base>, <power>) - power
// $power = pow($number, 2);
// echo"Power of 2: {$power} <br>";


// sqrt() - return square root of a number
// $squareRoot = sqrt($number);
// echo("Square Root: {$squareRoot} <br>");

// max() -  return maximum of a given numbers
// $max = max($number, $number1, $number2);
// echo("Max: {$max} <br>");

// min() -  return minimum of a given numbers
// $min = max($number, $number1, $number2);
// echo("Min: {$min} <br>");

// pi() - return value of pi - 3.141592635898
// rand() - returns complete random number upto 2 billions
// rand(1, 6) - returns a random number within 1-6

/** ====================================================================== */

// Logical Operator: &&, ||, !
// Relational Operator: >, <, >=, <=, ==, !=
// Arithmatic operator: +, -, *, /, **(power), %
// Increment/decrement operator: ++, --

// Operator precedence(expression left to right)
// ()
// **
// *  /   %
// +  -

/** ====================================================================== */



?>