<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Setting up Movie Database...</h1>";

// Connect to MySQL (without specifying database)
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "<p>✅ Connected to MySQL</p>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS moviesdb";
if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Database 'moviesdb' created or already exists</p>";
} else {
    echo "<p>❌ Error creating database: " . $conn->error . "</p>";
}

// Select the database
$conn->select_db('moviesdb');

// Create movies table
$sql = "CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    release_year INT NOT NULL,
    rating INT NOT NULL,
    poster_url VARCHAR(500),
    watched_date DATE NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'movies' created or already exists</p>";
} else {
    echo "<p>❌ Error creating table: " . $conn->error . "</p>";
}

// Check if table is empty, if so insert sample data
$result = $conn->query("SELECT COUNT(*) as count FROM movies");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "<p>📝 Inserting sample data...</p>";
    
    $sample_data = [
        ['Inception', 'Sci-Fi', 2010, 9, 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_.jpg', '2023-01-15'],
        ['The Godfather', 'Crime', 1972, 10, 'https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg', '2022-12-10'],
        ['Interstellar', 'Sci-Fi', 2014, 8, 'https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg', '2023-02-20'],
        ['Parasite', 'Thriller', 2019, 9, 'https://m.media-amazon.com/images/M/MV5BYWZjMjk3ZTItODQ2ZC00NTY5LWE0ZDYtZTI3MjcwN2Q5NTVkXkEyXkFqcGdeQXVyODk4OTc3MTY@._V1_.jpg', '2023-03-05'],
        ['Spirited Away', 'Animation', 2001, 10, 'https://m.media-amazon.com/images/M/MV5BMjlmZmI5MDctNDE2YS00YWE0LWE5ZWItZDBhYWQ0NTcxNWRhXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg', '2023-04-12']
    ];
    
    $stmt = $conn->prepare("INSERT INTO movies (title, genre, release_year, rating, poster_url, watched_date) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($sample_data as $movie) {
        $stmt->bind_param('ssisss', $movie[0], $movie[1], $movie[2], $movie[3], $movie[4], $movie[5]);
        if ($stmt->execute()) {
            echo "<p>✅ Added: " . $movie[0] . "</p>";
        } else {
            echo "<p>❌ Error adding " . $movie[0] . ": " . $stmt->error . "</p>";
        }
    }
    $stmt->close();
} else {
    echo "<p>📋 Sample data already exists (" . $row['count'] . " movies)</p>";
}

// Show current movies
echo "<h2>Current Movies in Database:</h2>";
$result = $conn->query("SELECT * FROM movies ORDER BY id");
if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Title</th><th>Genre</th><th>Year</th><th>Rating</th><th>Poster URL</th><th>Watched Date</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
        echo "<td>" . $row['release_year'] . "</td>";
        echo "<td>" . $row['rating'] . "</td>";
        echo "<td>" . htmlspecialchars(substr($row['poster_url'], 0, 50)) . "...</td>";
        echo "<td>" . $row['watched_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No movies found in database.</p>";
}

$conn->close();

echo "<h2>✅ Setup Complete!</h2>";
echo "<p><a href='movies.php' style='background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Movie List</a></p>";
echo "<p><a href='add_movie.php' style='background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Add New Movie</a></p>";
?> 