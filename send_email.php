<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch subjects from the database
$query = "SELECT * FROM subjects";
$result = mysqli_query($conn, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST['subject_name']; // Subject Name
    $to = "recipient@example.com"; // Add your email here
    $subject = "Subject Viewed: $subject_name";
    $message = "Hello, the subject '$subject_name' has been viewed. \n\nContact info:\nEmail: your.email@example.com \nPhone: +1234567890";
    $headers = "From: your.email@example.com";

    if(mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-indigo-700 p-5">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-white">Attendance System</a>
            <div class="space-x-4">
                <a href="index.php" class="text-white hover:text-indigo-300">Home</a>
                <a href="login.php" class="text-white hover:text-indigo-300">Login</a>
                <a href="logout.php" class="text-white hover:text-indigo-300">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Section -->
    <section class="py-10 px-4">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-6">Manage Subjects Schedule</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead class="bg-indigo-700 text-white">
                        <tr>
                            <th class="py-2 px-4">Time</th>
                            <th class="py-2 px-4">Subject</th>
                            <th class="py-2 px-4">Activity</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through subjects and display them -->
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['time_start'] . ' - ' . $row['time_end']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['subject_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['activity']; ?></td>
                            <td class="py-2 px-4 space-x-2">
                                <form action="dashboard.php" method="POST" class="inline">
                                    <input type="hidden" name="subject_name" value="<?php echo $row['subject_name']; ?>">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Send Email</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Your Name. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
