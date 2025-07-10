<?php
$conn = new mysqli('localhost', 'root', '', 'moviesdb'); // Database name
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = intval($_POST['release_year']);
    $rating = intval($_POST['rating']);
    $poster_url = $_POST['poster_url'];
    $watched_date = $_POST['watched_date'];
    $stmt = $conn->prepare('UPDATE movies SET title=?, genre=?, release_year=?, rating=?, poster_url=?, watched_date=? WHERE id=?');
    $stmt->bind_param('ssisssi', $title, $genre, $release_year, $rating, $poster_url, $watched_date, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: movies.php');
    exit();
} else if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM movies WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p style='color: #ffb400; text-align:center;'>Movie not found.</p>";
        exit();
    }
} else {
    echo "<p style='color: #ffb400; text-align:center;'>No movie selected.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="movies.css">
    <style>
        .edit-form {
            max-width: 400px;
            margin: 40px auto;
            background: #222;
            padding: 24px 28px 18px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.7);
        }
        .edit-form label {
            display: block;
            margin-bottom: 6px;
            color: #ffb400;
            font-weight: bold;
        }
        .edit-form input[type="text"],
        .edit-form input[type="number"],
        .edit-form input[type="date"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 16px;
            border: 1px solid #444;
            border-radius: 6px;
            background: #292929;
            color: #f0f0f0;
            font-size: 1rem;
        }
        .edit-form button {
            background: #ffb400;
            color: #181818;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .edit-form button:hover {
            background: #e09c00;
        }
    </style>
</head>
<body>
    <form class="edit-form" method="post" action="edit_movie.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        <label>Genre</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($row['genre']); ?>" required>
        <label>Release Year</label>
        <input type="number" name="release_year" value="<?php echo $row['release_year']; ?>" required>
        <label>Rating</label>
        <input type="number" name="rating" min="1" max="10" value="<?php echo $row['rating']; ?>" required>
        <label>Poster URL</label>
        <input type="text" name="poster_url" value="<?php echo htmlspecialchars($row['poster_url']); ?>" required>
        <label>Watched Date</label>
        <input type="date" name="watched_date" value="<?php echo $row['watched_date']; ?>" required>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html> 