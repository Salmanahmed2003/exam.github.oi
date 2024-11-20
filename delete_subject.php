<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];

    $query = "DELETE FROM subjects WHERE id = $subject_id";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit();
}
?>
