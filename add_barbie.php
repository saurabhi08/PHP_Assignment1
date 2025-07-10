<?php
$conn = new mysqli('localhost', 'root', '', 'moviesdb');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if Barbie already exists
$title = 'Barbie';
$check = $conn->prepare('SELECT id FROM movies WHERE title = ?');
$check->bind_param('s', $title);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "<p>Barbie movie already exists in your list.</p>";
} else {
    $genre = 'Comedy, Adventure';
    $release_year = 2023;
    $rating = 7;
    $poster_url = 'https://m.media-amazon.com/images/M/MV5BMTYxYjQyYjUtYjA2Zi00YjQwLTk2YjMtYjQwYjQwYjQwYjQwXkEyXkFqcGdeQXVyMTUzOTcyODA5._V1_FMjpg_UX1000_.jpg';
    $watched_date = date('Y-m-d');
    $stmt = $conn->prepare('INSERT INTO movies (title, genre, release_year, rating, poster_url, watched_date) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssisss', $title, $genre, $release_year, $rating, $poster_url, $watched_date);
    if ($stmt->execute()) {
        echo "<p>Barbie movie added successfully!</p>";
    } else {
        echo "<p>Error adding Barbie: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$check->close();
$conn->close();
echo '<p><a href="movies.php">Go to Movie List</a></p>';
?> 