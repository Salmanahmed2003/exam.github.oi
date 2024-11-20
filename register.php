<?php
include('db_connection.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Insert new user into the database
    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    mysqli_query($conn, $query);
    echo "<div class='alert alert-success'>Registration successful!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Login SDK -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- Facebook Login SDK -->
    <script src="https://connect.facebook.net/en_US/sdk.js" async defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Register</h3>
                        <!-- Registration Form -->
                        <form method="POST" action="register.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>

                        <hr>

                        <!-- Social Login Buttons -->
                        <div class="text-center">
                            <!-- Google Login Button -->
                            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
                            <br>
                            <!-- Facebook Login Button -->
                            <div class="fb-login-button" data-size="large" data-scope="public_profile,email" data-onlogin="checkLoginState()"></div>
                        </div>

                        <hr>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <a href="login.php" class="btn btn-link">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Login Callback -->
    <script type="text/javascript">
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log("Full Name: " + profile.getName());
            console.log("Email: " + profile.getEmail());
        }
    </script>

    <!-- Facebook Login Callback -->
    <script type="text/javascript">
        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    console.log("Facebook login success");
                    FB.api('/me?fields=name,email', function(response) {
                        console.log("Name: " + response.name);
                        console.log("Email: " + response.email);
                    });
                } else {
                    console.log("Facebook login failed");
                }
            });
        }

        // Initialize Facebook SDK
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'YOUR_APP_ID', // Replace with your Facebook App ID
                cookie     : true,
                xfbml      : true,
                version    : 'v13.0'
            });
        };
    </script>
</body>
</html>
