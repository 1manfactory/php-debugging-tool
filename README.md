# PHP Debugging Tool

A comprehensive PHP debugging tool that helps you to debug your PHP applications directly in the browser. This tool includes error and exception handling, performance information, and the ability to filter and search through debugging information. It also features syntax highlighting and an option to export the debug information as an HTML file.

## Features

- **Error and Exception Handling**: Captures and displays PHP errors and exceptions.
- **Performance Information**: Displays script execution time and memory usage.
- **Variable Debugging**: Recursively displays all PHP variables, including GET, POST, SESSION, COOKIE, and SERVER variables.
- **User Interface**: Interactive interface to toggle, filter, and search debugging information.
- **Syntax Highlighting**: Uses Prism.js for syntax highlighting of variables.
- **Export Function**: Allows exporting of debug information as an HTML file.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/1manfactory/php-debugging-tool.git
   ```
2. **Include the debug script in your PHP files:**
   ```php
   <?php
   include 'path/to/debug.php';
   ?>
   ```

## Usage

### Basic Usage

Include the `debug.php` file at the beginning or end of your PHP scripts. The debugging information will only be displayed if the script is accessed via a web browser and not via CLI or AJAX calls with JSON response.

```php
<?php
include 'path/to/debug.php';
// Your PHP code here
?>
```

### Export Debug Information

You can export the debug information by clicking the "Export Debug Information" button at the bottom of the debug panel. This will generate and download an HTML file with all the debugging details.

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
- **Usage**: Basic usage instructions, including how to include the script and export debug information.
- **Full Code**: The complete PHP debugging script.
- **License, Contributing, and Acknowledgments**: Standard sections for open-source projects on GitHub.
