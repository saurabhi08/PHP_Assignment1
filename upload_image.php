<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['movie_image'])) {
    $target_dir = "images/";
    
    // Create images directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file = $_FILES['movie_image'];
    $fileName = basename($file['name']);
    $target_file = $target_dir . $fileName;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    if (getimagesize($file['tmp_name']) !== false) {
        // Check file size (5MB max)
        if ($file['size'] <= 5000000) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                if (move_uploaded_file($file['tmp_name'], $target_file)) {
                    echo "<p style='color: #4CAF50; text-align: center;'>Image uploaded successfully: " . $fileName . "</p>";
                    echo "<p style='text-align: center;'>Use this path in your database: images/" . $fileName . "</p>";
                } else {
                    echo "<p style='color: #f44336; text-align: center;'>Sorry, there was an error uploading your file.</p>";
                }
            } else {
                echo "<p style='color: #f44336; text-align: center;'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
            }
        } else {
            echo "<p style='color: #f44336; text-align: center;'>Sorry, your file is too large. Maximum size is 5MB.</p>";
        }
    } else {
        echo "<p style='color: #f44336; text-align: center;'>File is not an image.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Movie Image</title>
    <link rel="stylesheet" href="movies.css">
    <style>
        .upload-form {
            max-width: 400px;
            margin: 40px auto;
            background: #222;
            padding: 24px 28px 18px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.7);
        }
        .upload-form label {
            display: block;
            margin-bottom: 6px;
            color: #ffb400;
            font-weight: bold;
        }
        .upload-form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 16px;
            border: 1px solid #444;
            border-radius: 6px;
            background: #292929;
            color: #f0f0f0;
            font-size: 1rem;
        }
        .upload-form button {
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
        .upload-form button:hover {
            background: #e09c00;
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
    </style>
</head>
<body>
    <form class="upload-form" method="post" enctype="multipart/form-data">
        <h2 style="text-align: center; color: #ffb400; margin-bottom: 20px;">Upload Movie Image</h2>
        <label>Select Movie Poster Image:</label>
        <input type="file" name="movie_image" accept="image/*" required>
        <button type="submit">Upload Image</button>
    </form>
    <div class="back-link">
        <a href="movies.php">← Back to Movie List</a>
    </div>
</body>
</html> 