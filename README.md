# Movie List Web App

A PHP and MySQL web application to manage and display a list of movies. Features a modern black theme, responsive design, and CRUD operations (add, edit, delete movies).

## Features
- Add, edit, and delete movies
- Store movie data in a MySQL database
- Upload or link to movie poster images
- Responsive, modern black-themed UI
- W3C-valid HTML and CSS
- Secure database operations with prepared statements

## Technologies Used
- PHP
- MySQL
- HTML5 & CSS3

## Setup Instructions
1. **Clone or download this repository.**
2. Place the project folder in your web server directory (e.g., `C:/xampp/htdocs/webdev/assignment 1`).
3. Start Apache and MySQL using XAMPP.
4. Import or create the `moviesdb` database and `movies` table (see `setup_database.php` for automated setup).
5. Open `http://localhost/webdev/assignment%201/movies.php` in your browser.

## Database Structure
- Table: `movies`
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `title` (VARCHAR)
  - `genre` (VARCHAR)
  - `release_year` (INT)
  - `rating` (INT)
  - `poster_url` (VARCHAR)
  - `watched_date` (DATE)

## Screenshots
![Movie List Screenshot](screenshot.png)

## License
This project is for educational purposes. 