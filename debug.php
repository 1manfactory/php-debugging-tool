<?php
// Überprüfen, ob das Skript im CLI-Modus läuft oder ob ein AJAX-Call mit JSON-Ausgabe erfolgt
if (php_sapi_name() !== 'cli' && (!isset($_SERVER['HTTP_ACCEPT']) || stripos($_SERVER['HTTP_ACCEPT'], 'application/json') === false)) {
    // Error and Exception Handling
    function handleErrors($errno, $errstr, $errfile, $errline) {
        echo "<div class='debug-error'><strong>Error:</strong> [$errno] $errstr - $errfile:$errline</div>";
    }

    function handleExceptions($exception) {
        echo "<div class='debug-error'><strong>Exception:</strong> " . $exception->getMessage() . "</div>";
    }

    set_error_handler('handleErrors');
    set_exception_handler('handleExceptions');

    $start_time = microtime(true);
    $start_memory = memory_get_usage();
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Debug-Informationen</title>
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
            .filter-buttons {
                margin-bottom: 10px;
            }
            .debug-error, .debug-info, .debug-message {
                z-index: 1000000;
            }
        </style>
    </head>
    <body>
        <div id="debug-toggle">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/bug.png" alt="Debug anzeigen/verstecken"/>
        </div>
        <div id="debug-info">
            <input type="text" id="search-input" class="search-input" placeholder="Suche...">
            <div class="filter-buttons">
                <button onclick="filterDebug('all')">Alle</button>
                <button onclick="filterDebug('GET-Variablen')">GET</button>
                <button onclick="filterDebug('POST-Variablen')">POST</button>
                <button onclick="filterDebug('SESSION-Variablen')">SESSION</button>
                <button onclick="filterDebug('COOKIE-Variablen')">COOKIE</button>
                <button onclick="filterDebug('SERVER-Variablen')">SERVER</button>
            </div>
            <?php
            // Funktion zum rekursiven Debuggen von Variablen
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

            // GET-Variablen
            debug_var('GET-Variablen', $_GET);

            // POST-Variablen
            debug_var('POST-Variablen', $_POST);

            // SESSION-Variablen
            session_start();
            debug_var('SESSION-Variablen', $_SESSION);

            // COOKIE-Variablen
            debug_var('COOKIE-Variablen', $_COOKIE);

            // SERVER-Variablen
            debug_var('SERVER-Variablen', $_SERVER);

            // Eigens definierte Variablen
            foreach ($GLOBALS as $key => $value) {
                if (!in_array($key, array('_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_REQUEST', '_ENV', '_SESSION', 'GLOBALS'))) {
                    debug_var($key, $value);
                }
            }

            $end_time = microtime(true);
            $end_memory = memory_get_usage();
            $execution_time = $end_time - $start_time;
            $memory_used = $end_memory - $start_memory;

            echo "<div class='debug-info'><strong>Ausführungszeit:</strong> " . round($execution_time, 4) . " Sekunden</div>";
            echo "<div class='debug-info'><strong>Speicherverbrauch:</strong> " . round($memory_used / 1024, 2) . " KB</div>";
            ?>
            <form method="get">
                <button type="submit" name="export_debug" value="1">Debug-Informationen exportieren</button>
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
                var headers = document.getElementsByClassName('debug-header');
                var sections = document.getElementsByClassName('debug-section');
                for (var i = 0; i < headers.length; i++) {
                    var header = headers[i];
                    var content = header.nextElementSibling;
                    if (header.innerText.toLowerCase().indexOf(filter) > -1 || sections[i].innerText.toLowerCase().indexOf(filter) > -1) {
                        header.style.display = '';
                        if (content) content.style.display = '';
                    } else {
                        header.style.display = 'none';
                        if (content) content.style.display = 'none';
                    }
                }
            });

            function filterDebug(type) {
                var headers = document.getElementsByClassName('debug-header');
                for (var i = 0; i < headers.length; i++) {
                    var header = headers[i];
                    var content = header.nextElementSibling;
                    if (type === 'all' || header.getAttribute('data-type') === type) {
                        header.style.display = '';
                        if (content) content.style.display = '';
                    } else {
                        header.style.display = 'none';
                        if (content) content.style.display = 'none';
                    }
                }
            }
        </script>
    </body>
    </html>
    <?php
}
?>
