<?php
ob_start(); // Start output buffering

// Error and Exception Handling
function handleErrors($errno, $errstr, $errfile, $errline) {
    echo "<div class='debug-error'><strong>Error:</strong> [$errno] $errstr - $errfile:$errline</div>";
}

function handleExceptions($exception) {
    echo "<div class='debug-error'><strong>Exception:</strong> " . $exception->getMessage() . "</div>";
}

set_error_handler('handleErrors');
set_exception_handler('handleExceptions');

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to recursively debug variables
function debug_var($var_name, $var_value, $level = 0) {
    static $id_counter = 0;
    $id_counter++;
    $id = 'debug-' . $id_counter;

    if (is_array($var_value) || is_object($var_value)) {
        echo "<h2 class='debug-header' data-type='$var_name'><span class='debug-toggle' data-target='$id'>[+]</span> $var_name:</h2>";
        echo "<div id='$id' class='debug-section'><pre class='language-php'><code class='language-php'>" . print_r($var_value, true) . "</code></pre></div>";
    } else {
        echo "<h2 class='debug-header' data-type='$var_name'>$var_name:</h2>";
        echo '<pre class="debug-content language-php"><code class="language-php">' . print_r($var_value, true) . '</pre></code>';
    }
}

function debug_message($message) {
    echo "<div class='debug-message'>$message</div>";
}

// Main Debug Function
function showDebugInfo() {
    global $start_time, $start_memory;

    $start_time = $start_time ?? microtime(true);
    $start_memory = $start_memory ?? memory_get_usage();

    // Check if the script is running in CLI mode or if it is an AJAX call with JSON response
    if (php_sapi_name() !== 'cli' && (!isset($_SERVER['HTTP_ACCEPT']) || stripos($_SERVER['HTTP_ACCEPT'], 'application/json') === false)) {
        // Initialize global variables if they are not set
        if (!isset($_SESSION)) $_SESSION = [];
        if (!isset($_COOKIE)) $_COOKIE = [];
        if (!isset($_GET)) $_GET = [];
        if (!isset($_POST)) $_POST = [];
        if (!isset($_SERVER)) $_SERVER = [];

        // Export debug information if requested
        if (isset($_GET['export_debug']) && $_GET['export_debug'] == '1') {
            ob_start();
            // Generate the debug information
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Debug Information</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
            </head>
            <body>
                <?php
                // GET Variables
                debug_var('GET Variables', $_GET);

                // POST Variables
                debug_var('POST Variables', $_POST);

                // SESSION Variables
                debug_var('SESSION Variables', $_SESSION);

                // COOKIE Variables
                debug_var('COOKIE Variables', $_COOKIE);

                // SERVER Variables
                debug_var('SERVER Variables', $_SERVER);

                // Custom defined variables
                foreach ($GLOBALS as $key => $value) {
                    if (!in_array($key, array('_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_REQUEST', '_ENV', '_SESSION', 'GLOBALS'))) {
                        debug_var($key, $value);
                    }
                }

                $end_time = microtime(true);
                $end_memory = memory_get_usage();
                $execution_time = $end_time - $start_time;
                $memory_used = $end_memory - $start_memory;

                echo "<div><strong>Execution Time:</strong> " . round($execution_time, 4) . " seconds</div>";
                echo "<div><strong>Memory Usage:</strong> " . round($memory_used / 1024, 2) . " KB</div>";
                ?>
            </body>
            </html>
            <?php
            $content = ob_get_clean();
            header('Content-Type: text/html');
            header('Content-Disposition: attachment; filename="debug_info.html"');
            echo $content;
            exit;
        }

        // Get the last filter value from a cookie
        $last_filter = isset($_COOKIE['debug_last_filter']) ? $_COOKIE['debug_last_filter'] : '';
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Debug Information</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
            <style>
                #debug-toggle {
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    cursor: pointer;
                    z-index: 1000001;
                    background: black;
                    padding: 10px;
                    border-radius: 50%;
                }
                #debug-toggle img {
                    width: 30px;
                    height: 30px;
                }
                #debug-info {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.9);
                    overflow: auto;
                    z-index: 1000000;
                    padding: 20px;
                    box-sizing: border-box;
                }
                .debug-section {
                    margin-left: 20px;
                    display: none;
                }
                .debug-toggle {
                    cursor: pointer;
                    color: blue;
                    text-decoration: underline;
                }
                .search-input {
                    margin-bottom: 10px;
                    width: 100%;
                    padding: 10px;
                    box-sizing: border-box;
                }
                .debug-error, .debug-info, .debug-message {
                    z-index: 1000000;
                }
            </style>
        </head>
        <body>
            <div id="debug-toggle">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/bug.png" alt="Toggle Debug"/>
            </div>
            <div id="debug-info">
                <input type="text" id="search-input" class="search-input" placeholder="Search..." value="<?php echo htmlspecialchars($last_filter); ?>">
                <?php
                // GET Variables
                debug_var('GET Variables', $_GET);

                // POST Variables
                debug_var('POST Variables', $_POST);

                // SESSION Variables
                debug_var('SESSION Variables', $_SESSION);

                // COOKIE Variables
                debug_var('COOKIE Variables', $_COOKIE);

                // SERVER Variables
                debug_var('SERVER Variables', $_SERVER);

                // Custom defined variables
                foreach ($GLOBALS as $key => $value) {
                    if (!in_array($key, array('_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_REQUEST', '_ENV', '_SESSION', 'GLOBALS'))) {
                        debug_var($key, $value);
                    }
                }

                $end_time = microtime(true);
                $end_memory = memory_get_usage();
                $execution_time = $end_time - $start_time;
                $memory_used = $end_memory - $start_memory;

                echo "<div class='debug-info'><strong>Execution Time:</strong> " . round($execution_time, 4) . " seconds</div>";
                echo "<div class='debug-info'><strong>Memory Usage:</strong> " . round($memory_used / 1024, 2) . " KB</div>";
                ?>
                <form method="get" target="_blank">
                    <button type="submit" name="export_debug" value="1">Export Debug Information</button>
                </form>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
            <script>
                document.getElementById('debug-toggle').addEventListener('click', function() {
                    var debugInfo = document.getElementById('debug-info');
                    if (debugInfo.style.display === 'none' || debugInfo.style.display === '') {
                        debugInfo.style.display = 'block';
                    } else {
                        debugInfo.style.display = 'none';
                    }
                });

                var toggles = document.getElementsByClassName('debug-toggle');
                for (var i = 0; i < toggles.length; i++) {
                    toggles[i].addEventListener('click', function() {
                        var target = document.getElementById(this.getAttribute('data-target'));
                        if (target.style.display === 'none' || target.style.display === '') {
                            target.style.display = 'block';
                            this.innerText = '[-]';
                        } else {
                            target.style.display = 'none';
                            this.innerText = '[+]';
                        }
                    });
                }

                document.getElementById('search-input').addEventListener('input', function() {
                    var filter = this.value.toLowerCase();
                    setCookie('debug_last_filter', filter, 7);
                    applyFilter(filter);
                });

                function setCookie(name, value, days) {
                    var expires = "";
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days*24*60*60*1000));
                        expires = "; expires=" + date.toUTCString();
                    }
                    document.cookie = name + "=" + (value || "")  + expires + "; path=/; SameSite=Lax";
                }

                function getCookie(name) {
                    var nameEQ = name + "=";
                    var ca = document.cookie.split(';');
                    for(var i=0;i < ca.length;i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') c = c.substring(1,c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                    }
                    return null;
                }

                function applyFilter(filter) {
                    var headers = document.getElementsByClassName('debug-header');
                    var sections = document.getElementsByClassName('debug-section');
                    for (var i = 0; i < headers.length; i++) {
                        var header = headers[i];
                        var content = header.nextElementSibling;
                        if (header.getAttribute('data-type').toLowerCase().indexOf(filter) > -1 || (sections[i] && sections[i].innerText.toLowerCase().indexOf(filter) > -1)) {
                            header.style.display = '';
                            if (content) content.style.display = '';
                        } else {
                            header.style.display = 'none';
                            if (content) content.style.display = 'none';
                        }
                    }
                }

                // Apply the last used filter from cookie
                window.onload = function() {
                    var lastFilter = getCookie('debug_last_filter');
                    if (lastFilter) {
                        applyFilter(lastFilter);
                        document.getElementById('search-input').value = lastFilter;
                    } else {
                        applyFilter('');
                        document.getElementById('search-input').value = '';
                    }
                };
            </script>
        </body>
        </html>
        <?php
    }
}

ob_end_flush(); // Send the output buffer
