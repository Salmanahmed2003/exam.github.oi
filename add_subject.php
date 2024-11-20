<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $subject_name = $_POST['subject_name'];
    $activity = $_POST['activity'];

    $query = "INSERT INTO subjects (time_start, time_end, subject_name, activity) VALUES ('$time_start', '$time_end', '$subject_name', '$activity')";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="bg-indigo-700 p-5">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-white">schedule</a>
            <div class="space-x-4">
                <a href="index.php" class="text-white hover:text-indigo-300">Home</a>
                <a href="about.php" class="text-white hover:text-indigo-300">About</a>
                <a href="login.php" class="text-white hover:text-indigo-300">Login</a>
                <a href="logout.php" class="text-white hover:text-indigo-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Add a New Subject</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="time_start" class="form-label">Start Time</label>
                                <input type="time" name="time_start" class="form-control" id="time_start" required>
                            </div>
                            <div class="mb-3">
                                <label for="time_end" class="form-label">End Time</label>
                                <input type="time" name="time_end" class="form-control" id="time_end" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject_name" class="form-label">Subject Name</label>
                                <input type="text" name="subject_name" class="form-control" id="subject_name" placeholder="Enter Subject Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="activity" class="form-label">Activity</label>
                                <textarea name="activity" class="form-control" id="activity" rows="3" placeholder="Enter Activity Details" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Subject</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
