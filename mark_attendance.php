<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch subjects and count activities
$query = "SELECT subject_name, COUNT(*) AS count FROM subjects GROUP BY subject_name";
$result = mysqli_query($conn, $query);
$subject_names = [];
$subject_counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subject_names[] = $row['subject_name'];
    $subject_counts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <!-- Chart Section -->
            <div class="mb-6">
                <canvas id="subjectChart" width="400" height="200"></canvas>
            </div>

            <div class="flex justify-end mb-4">
                <a href="add_subject.php" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Subject</a>
            </div>
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
                                <a href="update_subject.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</a>
                                <form action="delete_subject.php" method="POST" class="inline">
                                    <input type="hidden" name="subject_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
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

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('subjectChart').getContext('2d');
        const subjectChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($subject_names); ?>,
                datasets: [{
                    label: 'Number of Subjects',
                    data: <?php echo json_encode($subject_counts); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.6)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true
            }
        });
    </script>
</body>
</html>
