<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn = new mysqli('localhost', 'root', '', 'moviesdb'); // Database name
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    $stmt = $conn->prepare('DELETE FROM movies WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
header('Location: movies.php');
exit(); 