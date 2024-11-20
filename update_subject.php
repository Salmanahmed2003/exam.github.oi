<?php
include('db_connection.php');

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the subject
    $query = "SELECT * FROM subjects WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $subject = mysqli_fetch_assoc($result);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end'];
        $subject_name = $_POST['subject_name'];
        $activity = $_POST['activity'];

        // Update the subject details in the database
        $update_query = "UPDATE subjects SET time_start = '$time_start', time_end = '$time_end', subject_name = '$subject_name', activity = '$activity' WHERE id = $id";
        
        if (mysqli_query($conn, $update_query)) {
            header("Location: dashboard.php?message=Subject+updated+successfully");
        } else {
            echo "Error updating subject: " . mysqli_error($conn);
        }
    }
} else {
    echo "Subject ID not found.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Attendance System</a>
            <div class="d-flex">
                <a href="dashboard.php" class="btn btn-light">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Update Form -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Update Subject</h2>

        <form method="POST" class="p-4 bg-white shadow-sm rounded">
            <div class="mb-3">
                <label for="time_start" class="form-label">Start Time</label>
                <input type="time" class="form-control" name="time_start" value="<?php echo $subject['time_start']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="time_end" class="form-label">End Time</label>
                <input type="time" class="form-control" name="time_end" value="<?php echo $subject['time_end']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" name="subject_name" value="<?php echo $subject['subject_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="activity" class="form-label">Activity</label>
                <textarea class="form-control" name="activity" rows="3" required><?php echo $subject['activity']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
