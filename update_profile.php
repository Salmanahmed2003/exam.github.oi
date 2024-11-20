<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboaard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get form data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password']; // Password (will be hashed if changed)
$profile_image = $_FILES['profile_image'];

// Default query to update username and email
$query_update = "UPDATE users SET username = '$username', email = '$email' WHERE id = '$user_id'";

// Update password if provided
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query_update = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$user_id'";
}

// Handle profile image upload
if ($profile_image['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = $profile_image['type'];
    
    if (in_array($file_type, $allowed_types)) {
        $file_name = time() . "_" . basename($profile_image['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($profile_image['tmp_name'], $target_file)) {
            $query_update = "UPDATE users SET username = '$username', email = '$email', profile_image = '$file_name' WHERE id = '$user_id'";
        }
    }
}

// Execute the update query
if (mysqli_query($conn, $query_update)) {
    header("Location: dashboard.php");
    exit();
} else {
    die('Error updating profile: ' . mysqli_error($conn));
}
?>
