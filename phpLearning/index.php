<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./../index.css">
</head>
<body>
  <h1 class="bg-green-900 text-white font-bold text-center py-4 text-2xl mb-6 w-full">Welcome to PHP Learning</h1>
  <!-- <form action="index.php" method="post">
    <label for="username">Username:</label>
    <input class="border" type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input class="border" type="password" id="password" name="password" required>
    <br>
    <input class="border" type="submit" value="Submit">
  </form> -->

  <!-- Some Math functions -->
   <!-- <form action="index.php" method="get">
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
   </form> -->
  
</body>
</html>

<?php
 // Variables
 // $<variable-name> = <value>
//  $x = "Hello world!";
//  $y = 1234;

 // Print
//  echo "$x <br> $y";

//  $proma = "Proma didi";
//  echo "This is {$proma}";

/** =================================================================== */

/**
 *  Get form data from HTML (not secure)
 *  $_GET["<value of name attrubute>"] global varibale
 *  embeds value into the url
 *  index.php?username=devAjmain&password=dsfsdf */

//  $username = $_GET["username"];
//  $password = $_GET["password"];
//  echo "username: {$username} <br> password: {$password}";

// $username = $_POST["username"];
// echo $username;

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

// $number = 5.2;

// abs() returns absolute/positive value
// $absolute = abs($number);
// echo "absolute value: {$absolute} <br>";

// round() returns rounded numbers (if decimal is < 0.5 then number floor, if decimal is >= 0.5 then number ceils)
// $round = round($number);
// echo "Rounded: {$round} <br>";

// // floor()
// $floor = floor($number);
// echo "Floor: {$floor} <br>";

// // ceil()
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
// echo pi();
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

// Arrays
// $foods = array("apple", "banana", "orange", "coconut");

// array_push($foods, "tomato", "cake");  // Inserts Items from the end
// array_pop($foods); // Removes last item
// array_shift($foods); // Removes first Item
// $foods1 = array_reverse($foods); // Reverse the item index
// echo count($foods) . "<br>";

// foreach($foods as $food){
//   echo $food . "<br>";
// }


/** ======================================================================= */

// Associativve array - key => value paris array

// $associative = array("name" => "orange", 
//                       "age" => 25, 
//                       "country" => "Dreamland");

// $associative["name"] = "Apple";

// foreach($associative as $key => $value){
//   echo $key, " = ", $value . "<br>";
// }

// $associative["age"] = 45;

// echo $associative["age"];


/** ========================================================================= */

// isset() - Returns TRUE if a variable is declared and not nul
// empty() - Returns TRUE if a varibale is not declared,  false, null, ""


/** ========================================================================= */

// Funations - block of re-usable code

// function is_even(){
//   echo "2 is even number";
// }

// is_even();

/** ========================================================================= */

// String Functions

// $username = "Pine Apple";



// echo $username;

?>