<?php
// UNSAFE: This code demonstrates insecure usage of user input

// Assume this is a search form that submits via GET
$search = $_GET['query']; // <-- unsanitized input

// Used directly in an SQL query
$conn = new mysqli("localhost", "user", "password", "example_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dangerous: SQL Injection vulnerability
$sql = "SELECT * FROM users WHERE name = '$search'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "User: " . $row["name"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
