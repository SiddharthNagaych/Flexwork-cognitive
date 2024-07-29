<?php
$servername = "localhost"; // Replace with your MySQL host
$username = "u518332725_flexwork"; // Replace with your MySQL username
$password = "Sidyat1234@#"; // Replace with your MySQL password
$dbname = "u518332725_FlexWork"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$college = $_POST['college'];
$branch = $_POST['branch'];
$gender = $_POST['gender'];
$position = $_POST['position'];

// Prepare SQL statement using prepared statements to prevent SQL injection
$sql = "INSERT INTO job_forms (email, name, phone, college, branch, gender, position)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = $conn->prepare($sql);

// Bind parameters to the prepared statement
$stmt->bind_param("sssssss", $email, $name, $phone, $college, $branch, $gender, $position);

// Execute the prepared statement
if ($stmt->execute()) {
    // Success message HTML with Tailwind CSS
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Job Application Form Submission Successful</title>
        <link rel="icon" href="/images/favicon.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">
        <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-2xl">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Form Submission Successful</h1>
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                Your job application form has been submitted successfully!
            </div>
            <div class="mt-8 text-center">
                <a href="index.html" class="text-blue-600 hover:underline">Go back to the HomePage</a>
            </div>
        </div>
    </body>
    </html>';
} else {
    // Error message HTML with Tailwind CSS
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Submission Failed</title>
        <link rel="icon" href="/images/logo7.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">
        <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-2xl">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Form Submission Failed</h1>
            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                There was an error submitting your job application form. Please try again.
            </div>
            <div class="mt-8 text-center">
                <a href="index.html" class="text-blue-600 hover:underline">Go back to the HomePage</a>
            </div>
        </div>
    </body>
    </html>';
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>

