<?php
// Debug script to check database and table
$conn = new mysqli('localhost', 'root', '', 'moviesdb');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "<h2>Database Connection: OK</h2>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'movies'");
if ($result->num_rows > 0) {
    echo "<h2>Table 'movies' exists: OK</h2>";
} else {
    echo "<h2>Table 'movies' does NOT exist!</h2>";
    exit();
}

// Show table structure
echo "<h2>Table Structure:</h2>";
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
echo "<h2>Current Movies:</h2>";
$result = $conn->query("SELECT * FROM movies");
if ($result) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Title</th><th>Genre</th><th>Year</th><th>Rating</th><th>Poster URL</th><th>Watched Date</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['genre'] . "</td>";
        echo "<td>" . $row['release_year'] . "</td>";
        echo "<td>" . $row['rating'] . "</td>";
        echo "<td>" . substr($row['poster_url'], 0, 50) . "...</td>";
        echo "<td>" . $row['watched_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();
?> 