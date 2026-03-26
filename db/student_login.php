<?php
// Start session to store user data after login
session_start();

// Include database connection file
include "db_connect.php";

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get data from form and remove extra spaces
    $enrollment = trim($_POST['EnrollmentNumber']);
    $password = trim($_POST['createdpassword']);

    // SQL query to check if user exists with matching enrollment and password
    $sql = "SELECT * FROM student 
            WHERE EnrollmentNumber='$enrollment' 
            AND Password='$password' 
            LIMIT 1";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if any record is found (login success)
    if ($result && mysqli_num_rows($result) > 0) {

        // Fetch user data from database
        $student = mysqli_fetch_assoc($result);

        // Store user data in session variables
        $_SESSION['StudentID'] = $student['id']; // primary key
        $_SESSION['FullName'] = $student['FullName']; // student name
        $_SESSION['EnrollmentNumber'] = $student['EnrollmentNumber']; // enrollment number

        // Redirect to dashboard page after successful login
        header("Location: ../db/std.php");
        exit();
    } else {
        // If no match found → login failed
        header("Location: ../login_error.html");
        exit();
    }
} else {
    // If user tries to access this file directly without form submission
    header("Location: ../login1.html");
    exit();
}
