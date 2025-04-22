<?php
// Hardcoded secrets (Sensitive Data Exposure)
$adminPassword = "admin123";                  // Hardcoded password
$awsAccessKey = "AKIAIOSFODNN7EXAMPLE";       // Fake AWS Access Key ID
$awsSecretKey = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY";  // Fake AWS Secret Key
$jwtToken    = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2Mj...";  // Fake JWT token
$privateKey  = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASC...\n-----END PRIVATE KEY-----";  // Fake private key

// Weak password hashing (Cryptographic Failure)
$userPassword = $_POST['password'];
$pwdHash = md5($userPassword);               // Using MD5 for passwords is insecure

// SQL injection vulnerability (Injection)
$id = $_GET['id'];
mysql_query("SELECT * FROM users WHERE id = " . $id);  // Unsanitized input in query

// Cross-Site Scripting (XSS) vulnerability
echo "Welcome, " . $_GET['name'];            // Outputting unsanitized user input

// Unsafe file inclusion (Local File Inclusion)
include($_GET['page']);                     // Including a file based on user input

// Server-Side Request Forgery (SSRF)
$url = $_GET['url'];
$response = file_get_contents($url);        // Fetches a URL provided by the user

// Insecure logging of sensitive data
error_log("User password: " . $userPassword); // Logging a sensitive password to a log file

// Insecure deserialization
$data = $_POST['data'];
$obj = unserialize($data);                  // Untrusted data deserialized (unsafe)
?>
