<?php
// Replace with your MySQL database credentials
$host = 'localhost';
$username = 'u518332725_flexwork';
$password = 'Sidyat1234@#';
$database = 'u518332725_FlexWork';

// Establish MySQL database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $branch = $_POST['branch'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $domain = $_POST['domain'];
    $year = $_POST['year'];

    // Prepare SQL statement to insert data into MySQL table
    $sql = "INSERT INTO internship_forms (name, gender, college, program, branch, email, phone, domain, year)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $gender, $college, $program, $branch, $email, $phone, $domain, $year);

    // Execute the statement
    if ($stmt->execute()) {
        // Display success message with Tailwind CSS
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Form Submission Successful</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="icon" href="/images/favicon.png" type="image/x-icon">
        </head>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">
            <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-2xl">
                <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Form Submission Successful</h1>
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    Your form has been submitted successfully!
                </div>
                <div class="mt-8 text-center">
                    <a href="index.html" class="text-blue-600 hover:underline">Go back to the HomePage</a>
                </div>
            </div>
        </body>
        </html>';
    } else {
        // Display error message with Tailwind CSS
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Form Submission Failed</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        </head>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">
            <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-2xl">
                <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Form Submission Failed</h1>
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    There was an error submitting your form. Please try again.
                </div>
                <div class="mt-8 text-center">
                    <a href="index.html" class="text-blue-600 hover:underline">Go back to the form</a>
                </div>
            </div>
        </body>
        </html>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: index.html");
    exit();
}
?>

