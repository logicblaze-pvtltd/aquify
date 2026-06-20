<?php
// Function to load .env file
if (!function_exists('loadEnv')) {
    function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Ignore comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Split by the first '=' character
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);

                // Remove surrounding quotes if they exist
                if ((strpos($value, '"') === 0 && substr($value, -1) === '"') ||
                    (strpos($value, "'") === 0 && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }

                // Set env variables
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}

// Load the .env file from the root directory
loadEnv(dirname(__DIR__) . '/.env');

// Database credentials with fallback to default local values
$servername = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost');
$username   = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
$password   = getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($_ENV['DB_PASS'] ?? '');
$dbname     = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'water_management');

// App Config settings
$app_name   = getenv('APP_NAME') ?: ($_ENV['APP_NAME'] ?? 'Aquify');
$app_url    = getenv('APP_URL') ?: ($_ENV['APP_URL'] ?? 'http://localhost/aquify');

if (!defined('APP_NAME')) {
    define('APP_NAME', $app_name);
}
if (!defined('APP_URL')) {
    define('APP_URL', rtrim($app_url, '/'));
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>