<?php
require_once 'path/to/vendor/autoload.php'; // Twilio PHP library
use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST['subject_name']; // Subject Name
    
    // Twilio credentials
    $sid    = "your_account_sid";
    $token  = "your_auth_token";
    $from   = "your_twilio_phone_number"; // Your Twilio phone number
    $to     = "recipient_phone_number"; // Recipient's phone number

    // Create Twilio client
    $client = new Client($sid, $token);

    // Send SMS
    $message = $client->messages->create(
        $to,
        [
            'from' => $from,
            'body' => "Subject viewed: $subject_name\nContact info: Email: your.email@example.com, Phone: +1234567890"
        ]
    );

    echo "SMS sent: " . $message->sid;
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
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Send SMS</button>
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
