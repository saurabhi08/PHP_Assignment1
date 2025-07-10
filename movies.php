<?php
// Database connection settings
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "moviesdb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Movie List</title>
    <link rel="stylesheet" href="movies.css">
</head>
<body>
    <div class="container">
        <h1>My Movie List</h1>
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="add_movie.php" class="add-btn">Add New Movie</a>
        </div>
        <div class="movies-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $topRated = $row['rating'] >= 9;
                $poster = !empty($row['poster_url']) ? $row['poster_url'] : 'https://via.placeholder.com/120x180/292929/888888?text=No+Poster';
                echo '<div class="movie-card' . ($topRated ? ' top-rated' : '') . '">';
                echo '<img src="' . htmlspecialchars($poster) . '" alt="' . htmlspecialchars($row['title']) . ' Poster">';
                echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                echo '<p><strong>Genre:</strong> ' . htmlspecialchars($row['genre']) . '</p>';
                echo '<p><strong>Year:</strong> ' . htmlspecialchars($row['release_year']) . '</p>';
                echo '<p><strong>Rating:</strong> ' . htmlspecialchars($row['rating']) . '</p>';
                echo '<p><strong>Watched:</strong> ' . htmlspecialchars($row['watched_date']) . '</p>';
                if ($topRated) {
                    echo '<span class="badge">Top Rated!</span>';
                }
                echo '<div class="movie-actions">';
                echo '<a class="edit-btn" href="edit_movie.php?id=' . $row['id'] . '">Edit</a> ';
                echo '<a class="delete-btn" href="delete_movie.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this movie?\');">Delete</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No movies found.</p>';
        }
        ?>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?> 