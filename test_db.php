<?php
// Test database connection
echo "<h2>Testing Database Connection...</h2>";

// Connect to MySQL without specifying database
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "<p>✅ Connected to MySQL successfully</p>";

// Show all databases
echo "<h3>Available Databases:</h3>";
$result = $conn->query("SHOW DATABASES");
if ($result) {
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
}

$conn->close();
?> 