<?php
// Include database connection
include "db_connect.php";

// Show errors (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data and remove extra spaces
    $fullname = trim($_POST['username']);
    $email = trim($_POST['email']);
    $employeeId = trim($_POST['EmployeeId']);
    $password = trim($_POST['password']);

    // Validate Employee ID (must be exactly 5 digits)
    if (strlen($employeeId) != 5 || !is_numeric($employeeId)) {
        echo "<script>alert('Employee ID must be exactly 5 digits'); window.location='../login2.html';</script>";
        exit();
    }

    // Check if email or employee ID already exists
    $check = mysqli_query($conn, 
        "SELECT * FROM teacher WHERE Email='$email' OR EmployeeID='$employeeId'"
    );

    if (mysqli_num_rows($check) > 0) {
        // User already exists
        header("Location: ../alreadyexist1.html");
        exit();
    }

    // 🔒 SECURE VERSION (Recommended)
    // $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert teacher data into database
    $sql = "INSERT INTO teacher (FullName, Email, EmployeeID, Password)
            VALUES ('$fullname', '$email', '$employeeId', '$password')";

    if (mysqli_query($conn, $sql)) {
        // Success → redirect to login page
        header("Location: ../login2.html");
        exit();
    } else {
        // Show error if query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);

} else {
    // If accessed without form submission
    echo "No form submitted!";
}
?>