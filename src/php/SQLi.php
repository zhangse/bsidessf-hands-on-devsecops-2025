<?php
// A02: Cryptographic Failures — Weak encryption
function storePassword($password) {
    // Insecure: MD5 is not suitable for password hashing
    $hash = md5($password);
    file_put_contents("passwords.txt", $hash . PHP_EOL, FILE_APPEND);
}

// A03: Injection — SQL Injection
$conn = new mysqli("localhost", "user", "password", "example_db");
$user = $_GET['user']; // unsanitized
$pass = $_GET['pass']; // unsanitized

$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
$result = $conn->query($sql);

// A07: Authentication Failure — no rate limiting, weak check
if ($result->num_rows > 0) {
    echo "Welcome, $user";
    setcookie("auth", "admin", time() + 3600); // A01: Broken Access Control
} else {
    echo "Invalid login";
}

// A05: Security Misconfiguration — Exposing PHP errors
ini_set('display_errors', 1); // Should be off in production

// A03: XSS — Output unsanitized input
$search = $_GET['search'];
echo "Results for: " . $search; // Reflects directly into HTML

// A10: SSRF — Using unsanitized input in a server-side HTTP request
$url = $_GET['url']; // example: http://127.0.0.1/admin
$response = file_get_contents($url);
echo "Fetched content: " . htmlentities($response);

// A08: Software/Data Integrity — Dangerous include from user input
$module = $_GET['module']; // e.g., ?module=logger
include("$module.php"); // Unsafe dynamic include

// A09: Logging Failures — Logs sensitive data
error_log("Login attempt by $user with password $pass");
