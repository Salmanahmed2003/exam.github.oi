<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data for pre-filling the form
$query_user = "SELECT username, email, profile_image FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query_user);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

$user_data = mysqli_fetch_assoc($result);
if (!$user_data) {
    die('User not found or no data returned.');
}

$username = $user_data['username'];
$email = $user_data['email'];
$profile_image = $user_data['profile_image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

    <!-- Edit Profile Form -->
    <section class="py-10 px-4">
        <div class="container mx-auto max-w-md bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold mb-6 text-center">Edit Your Profile</h2>
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">New Password (Optional)</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded">
                </div>

                <!-- Profile Image -->
                <div class="mb-4">
                    <label for="profile_image" class="block text-gray-700">Profile Image (Optional)</label>
                    <input type="file" name="profile_image" id="profile_image" class="w-full p-2 border border-gray-300 rounded">
                </div>

                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded w-full">Update Profile</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Your Name</p>
        </div>
    </footer>
</body>
</html>
