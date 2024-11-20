<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data (username and profile image)
$user_id = $_SESSION['user_id'];
$query_user = "SELECT username, profile_image FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query_user);

// Check if the query was successful
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Fetch user data
$user_data = mysqli_fetch_assoc($result);
if (!$user_data) {
    die('User not found or no data returned.');
}

$username = $user_data['username'];
$profile_image = $user_data['profile_image'];

// Query to get Subject Count
$query_subject_count = "SELECT COUNT(*) AS subject_count FROM subjects";
$result_subject_count = mysqli_query($conn, $query_subject_count);
$subject_count = mysqli_fetch_assoc($result_subject_count)['subject_count'];

// Query to get Upcoming Activity
$query_upcoming_activity = "SELECT activity FROM subjects ORDER BY time_start LIMIT 1";
$result_upcoming_activity = mysqli_query($conn, $query_upcoming_activity);
$upcoming_activity = mysqli_fetch_assoc($result_upcoming_activity);

// Query to get Recent Subjects
$query_recent_subjects = "SELECT subject_name FROM subjects ORDER BY time_start DESC LIMIT 3";
$result_recent_subjects = mysqli_query($conn, $query_recent_subjects);
$recent_subjects = [];
while ($row = mysqli_fetch_assoc($result_recent_subjects)) {
    $recent_subjects[] = $row['subject_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
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

    <!-- Dashboard Section -->
    <section class="py-10 px-4">
        <div class="container mx-auto">
            <!-- Profile Section -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-semibold mb-4">Welcome, <?php echo $username; ?></h2>
                <?php if ($profile_image): ?>
                    <img src="uploads/<?php echo $profile_image; ?>" alt="Profile Image" class="w-32 h-32 rounded-full mx-auto mb-4">
                <?php else: ?>
                    <img src="image/suleiman ahmed salad mohamed.jpg" alt="Default Avatar" class="w-32 h-32 rounded-full mx-auto mb-4">
                <?php endif; ?>
                <p class="text-lg text-gray-700">Manage your attendance and subjects here.</p>
            </div>

            <!-- Subject Management -->
            <h2 class="text-3xl font-semibold mb-6 text-center">Manage Subjects Schedule</h2>
            <div class="flex justify-end mb-4">
                <a href="add_subject.php" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Subject</a>
            </div>

            <!-- Subject Count, Upcoming Activity, Recent Updates -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Subject Count Card -->
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <h3 class="text-xl font-semibold">Subject Count</h3>
                    <p class="text-3xl font-bold"><?php echo $subject_count; ?></p>
                    <p class="text-gray-500">Total subjects in the system.</p>
                </div>
                
                <!-- Upcoming Activity Card -->
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <h3 class="text-xl font-semibold">Upcoming Activity</h3>
                    <p class="text-lg"><?php echo $upcoming_activity['activity'] ?? 'No upcoming activity.'; ?></p>
                </div>

                <!-- Recent Updates Card -->
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <h3 class="text-xl font-semibold">Recent Updates</h3>
                    <ul class="list-disc pl-5">
                        <?php foreach ($recent_subjects as $subject): ?>
                            <li><?php echo $subject; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Subject Table -->
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
                        <?php
                        $query_subjects = "SELECT * FROM subjects";
                        $result_subjects = mysqli_query($conn, $query_subjects);
                        while ($row = mysqli_fetch_assoc($result_subjects)) {
                        ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['time_start'] . ' - ' . $row['time_end']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['subject_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['activity']; ?></td>
                            <td class="py-2 px-4 space-x-2">
                                <a href="update_subject.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</a>
                                <!-- Mark Attendance Form -->
                                <form action="mark_attendance.php" method="POST" class="inline">
                                    <input type="hidden" name="subject_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="attendance_status" value="present" class="bg-green-500 text-white px-4 py-2 rounded">Mark Present</button>
                                    <button type="submit" name="attendance_status" value="absent" class="bg-red-500 text-white px-4 py-2 rounded">Mark Absent</button>
                                </form>
                                <!-- Delete Subject Form -->
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
            <p>&copy;copy_right:salman Ahmed Salad |2024</p>
        </div>
    </footer>
</body>
</html>
