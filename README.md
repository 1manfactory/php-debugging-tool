# PHP Debugging Tool

A simple PHP debugging tool to display various PHP variables such as GET, POST, SESSION, COOKIE, and SERVER variables. It also provides error and exception handling, and allows exporting the debug information as an HTML file.

## Features

- Display GET, POST, SESSION, COOKIE, and SERVER variables.
- Error and exception handling.
- Export debug information as an HTML file.
- Toggle debug information visibility.
- Filter debug information using a search box.
- Automatically disabled in production environments.

## Screenshots

![image](https://github.com/user-attachments/assets/44e546d7-150b-46b1-a34b-0054bd669356)




## Installation

1. Clone the repository or download the `debug.php` file.
2. Create an empty `.env_dev` file in the same directory as `debug.php` to enable debugging.

### Enabling Debugging

**Create an `.env_dev` file in the same directory as `debug.php`**:

```sh
touch .env_dev
```

3. Include `debug.php` in your main PHP script before any output is generated.

## Usage

### Including the Debugging Tool

Include the `debug.php` file at the beginning of your main PHP script:

```php
<?php
include 'path/to/debug.php';
?>
```

### Displaying Debug Information

Call the `showDebugInfo()` function at the end of your main PHP script to display the debug information. This function will do nothing in production environments:

```php
<?php
// Example variables
$_SESSION['username'] = 'demo_user';
$_GET['page'] = 'home';
$_POST['submit'] = 'Submit';
$_COOKIE['user'] = 'cookie_user';
$_SERVER['REQUEST_TIME'] = time();

// Add a custom debug message
debug_message('This is a custom debug message for demonstration purposes.');

// Display debug information
showDebugInfo();
?>
```

### HTML Example

```php
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

    <?php
    // Include the debug script
    include 'path/to/debug.php';

    // Example variables
    $_SESSION['username'] = 'demo_user';
    $_GET['page'] = 'home';
    $_POST['submit'] = 'Submit';
    $_COOKIE['user'] = 'cookie_user';
    $_SERVER['REQUEST_TIME'] = time();

    // Add a custom debug message
    debug_message('This is a custom debug message for demonstration purposes.');

    // Display debug information
    showDebugInfo();
    ?>
</body>
</html>
```

## Functions

### `debug_message($message)`

Add a custom debug message to be displayed.

- `$message` (string): The message to be displayed.

### `showDebugInfo()`

Displays the debug information at the point where it is called. It should be called at the end of your script to ensure all variables are captured. In production environments, this function does nothing.

## Exporting Debug Information

To export the debug information as an HTML file, append `?export_debug=1` to the URL in your browser.

Example:

```
http://yourdomain.com/yourscript.php?export_debug=1
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
