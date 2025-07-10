<?php
// Check movies table in moviesdb
echo "<h2>Checking moviesdb Database...</h2>";

$conn = new mysqli('localhost', 'root', '', 'moviesdb');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "<p>✅ Connected to moviesdb successfully</p>";

// Check if movies table exists
$result = $conn->query("SHOW TABLES LIKE 'movies'");
if ($result->num_rows > 0) {
    echo "<p>✅ Table 'movies' exists</p>";
    
    // Show table structure
    echo "<h3>Table Structure:</h3>";
    $result = $conn->query("DESCRIBE movies");
    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Show current data
    echo "<h3>Current Movies:</h3>";
    $result = $conn->query("SELECT * FROM movies");
    if ($result->num_rows > 0) {
        echo "<p>Found " . $result->num_rows . " movies</p>";
    } else {
        echo "<p>No movies in table yet</p>";
    }
    
} else {
    echo "<p>❌ Table 'movies' does NOT exist</p>";
}

$conn->close();
?> 