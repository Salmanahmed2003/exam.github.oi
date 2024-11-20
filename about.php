<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="bg-indigo-700 p-5">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-white">schedule</a>
            <div class="space-x-4">
                <a href="dashboard.php" class="text-white hover:text-indigo-300">Home</a>
                <a href="about.php" class="text-white hover:text-indigo-300">About</a>
                <a href="login.php" class="text-white hover:text-indigo-300">Login</a>
                <a href="logout.php" class="text-white hover:text-indigo-300">Logout</a>
            </div>
        </div>
    </nav>


    <!-- About Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="display-4 text-dark mb-4">About Us</h2>
                <p class="lead text-muted mb-4">
                    Welcome to our Attendance System! We are dedicated to helping institutions and organizations
                    effectively manage attendance records and streamline their scheduling and reporting processes.
                </p>
                <h4 class="font-weight-bold text-dark">Our Mission</h4>
                <p class="text-muted mb-4">
                    Our mission is to provide a reliable and efficient system for managing attendance, ensuring
                    that every record is accurate and up-to-date. We strive to simplify administrative tasks while
                    providing real-time access to attendance information.
                </p>
                <h4 class="font-weight-bold text-dark">Why Choose Us?</h4>
                <p class="text-muted">
                    We offer user-friendly interfaces, customizable features, and robust reporting tools to ensure that
                    managing attendance becomes a seamless experience. Our system is designed with security and
                    ease of use in mind, making it the ideal choice for any organization.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="image/suleiman ahmed salad mohamed.jpg" alt="About Us" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Attendance System | All Rights Reserved</p>
        </div>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
