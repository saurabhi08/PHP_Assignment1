<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', '', 'moviesdb'); // Database name
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = intval($_POST['release_year']);
    $rating = intval($_POST['rating']);
    $poster_url = trim($_POST['poster_url']); // Trim whitespace
    $watched_date = $_POST['watched_date'];
    
    // If poster URL is empty, use a default placeholder
    if (empty($poster_url)) {
        $poster_url = 'https://via.placeholder.com/120x180/292929/888888?text=No+Poster';
    }
    
    $stmt = $conn->prepare('INSERT INTO movies (title, genre, release_year, rating, poster_url, watched_date) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssisss', $title, $genre, $release_year, $rating, $poster_url, $watched_date);
    
    if ($stmt->execute()) {
        header('Location: movies.php');
        exit();
    } else {
        $error = "Error adding movie: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Movie</title>
    <link rel="stylesheet" href="movies.css">
    <style>
        .add-form {
            max-width: 400px;
            margin: 40px auto;
            background: #222;
            padding: 24px 28px 18px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.7);
        }
        .add-form h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .add-form label {
            display: block;
            margin-bottom: 6px;
            color: #ffb400;
            font-weight: bold;
        }
        .add-form input[type="text"],
        .add-form input[type="number"],
        .add-form input[type="date"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 16px;
            border: 1px solid #444;
            border-radius: 6px;
            background: #292929;
            color: #f0f0f0;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .add-form button {
            background: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
        }
        .add-form button:hover {
            background: #45a049;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #ffb400;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .error {
            color: #ff4d4d;
            text-align: center;
            margin-bottom: 16px;
        }
        .help-text {
            color: #888;
            font-size: 0.9rem;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <form class="add-form" method="post" action="add_movie.php">
        <h2>Add New Movie</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <label>Movie Title *</label>
        <input type="text" name="title" required>
        
        <label>Genre *</label>
        <input type="text" name="genre" required>
        <div class="help-text">e.g., Action, Comedy, Drama, Sci-Fi, Horror</div>
        
        <label>Release Year *</label>
        <input type="number" name="release_year" min="1900" max="2030" required>
        
        <label>Rating (1-10) *</label>
        <input type="number" name="rating" min="1" max="10" required>
        
        <label>Poster URL (Optional)</label>
        <input type="text" name="poster_url" placeholder="https://example.com/poster.jpg">
        <div class="help-text">Leave empty for a placeholder image, or paste an image URL from IMDb/Google Images</div>
        
        <label>Watched Date *</label>
        <input type="date" name="watched_date" required>
        
        <button type="submit">Add Movie</button>
    </form>
    <div class="back-link">
        <a href="movies.php">← Back to Movie List</a>
    </div>
</body>
</html> 