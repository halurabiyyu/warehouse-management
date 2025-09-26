<?php
use Illuminate\Http\Request;

echo "<h1>Laravel Debug</h1>";

echo "<h2>1. File System Check:</h2>";
echo "Current dir: " . getcwd() . "<br>";
echo "vendor/autoload.php: " . (file_exists("../vendor/autoload.php") ? "EXISTS" : "MISSING") . "<br>";
echo "bootstrap/app.php: " . (file_exists("../bootstrap/app.php") ? "EXISTS" : "MISSING") . "<br>";
echo ".env file: " . (file_exists("../.env") ? "EXISTS" : "MISSING") . "<br>";

echo "<h2>2. Try Autoload:</h2>";
try {
    require_once "../vendor/autoload.php";
    echo "Autoload: SUCCESS<br>";
} catch (Exception $e) {
    echo "Autoload ERROR: " . $e->getMessage() . "<br>";
    exit;
}

echo "<h2>3. Try Bootstrap:</h2>";
try {
    $app = require_once "../bootstrap/app.php";
    echo "Bootstrap: SUCCESS<br>";
} catch (Exception $e) {
    echo "Bootstrap ERROR: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    exit;
}

echo "<h2>4. Check Environment:</h2>";
if (file_exists("../.env")) {
    $env = file_get_contents("../.env");
    echo "APP_KEY set: " . (strpos($env, "APP_KEY=base64:") !== false ? "YES" : "NO") . "<br>";
}

echo "<h2>5. Try Handle Request:</h2>";
try {
    $request = Request::capture();
    echo "Request captured: SUCCESS<br>";
    
    $response = $app->handleRequest($request);
    echo "Handle request: SUCCESS<br>";
} catch (Exception $e) {
    echo "Handle request ERROR: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
