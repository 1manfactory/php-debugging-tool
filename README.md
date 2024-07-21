# PHP Debugging Tool

This PHP debugging tool helps developers to debug their applications by providing detailed information about GET, POST, SESSION, COOKIE, SERVER variables, and custom variables. It includes features to display debug information in a collapsible section and export the debug information as an HTML file.

## Features

- Display GET, POST, SESSION, COOKIE, SERVER variables.
- Custom variables can also be displayed.
- Collapsible sections for better readability.
- Filter functionality to search through the debug information.
- Export debug information as an HTML file.

## Installation

1. Clone the repository or download the `debug.php` file.

2. Include the `debug.php` file in your PHP project:
    ```php
    include 'path/to/debug.php';
    ```

## Usage

### Basic Usage

Include the `debug.php` file at the beginning of your PHP file:
```php
<?php
include 'path/to/debug.php';
?>
```

### Displaying Debug Information

By default, the debug information will be displayed in a hidden section. To view the debug information, click the bug icon in the top-right corner of the page.

### Filtering Debug Information

Use the search input field to filter the debug information. The filter value is saved in a cookie and applied automatically when the page is reloaded.

### Exporting Debug Information

To export the debug information as an HTML file, click the "Export Debug Information" button. The debug information will be generated and downloaded as an HTML file.

### Example

Here is an example `index.php` file demonstrating the usage of the debugging tool:
```php
<?php
include 'path/to/debug.php'; // Include the debugging tool

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
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on the code of conduct, and the process for submitting pull requests.

## Acknowledgments

- Icon made by [Icons8](https://icons8.com/) from [Icons8](https://icons8.com/)
- Syntax highlighting by [Prism.js](https://prismjs.com/)

### Explanation

- **Title and Introduction**: Provides an overview of the project and its features.
- **Installation**: Instructions for cloning the repository and including the debug script in PHP files.
- **Usage**: Basic usage instructions, including how to include the script, display debug information, filter it, and export it.
- **Example**: Provides an example `index.php` file to demonstrate the usage of the tool.
- **License, Contributing, and Acknowledgments**: Standard sections for open-source projects on GitHub.
