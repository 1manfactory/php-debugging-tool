<?php
include 'path/to/debug.php'; // Include the debugging tool

// Start a session
session_start();

// Set some test variables
$_SESSION['username'] = 'demo_user';
$_SESSION['email'] = 'demo@example.com';
$_GET['page'] = 'home';
$_POST['submit'] = 'Submit';
$_COOKIE['user'] = 'cookie_user';
$_SERVER['REQUEST_TIME'] = time();

// Custom variables
$testArray = array('apple', 'banana', 'cherry');
$testObject = (object) array('name' => 'John Doe', 'age' => 30, 'email' => 'john.doe@example.com');

// Function to add a custom debug message
debug_message('This is a custom debug message for demonstration purposes.');

// HTML content for demonstration
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Debugging Tool Demo</title>
</head>
<body>
    <h1>Welcome to the PHP Debugging Tool Demo</h1>
    <p>This is a demo page to showcase the PHP Debugging Tool functionality.</p>
    <form method="post" action="">
        <input type="text" name="demo_input" placeholder="Enter something...">
        <input type="submit" name="submit" value="Submit">
    </form>
    <p>Some content on the page...</p>
    <p>More content...</p>
</body>
</html>
