<?php
session_start();
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment = $_POST['EnrollmentNumber'] ?? '';
    $createdpassword = $_POST['createdpassword'] ?? '';

    // Fetch student from DB by EnrollmentNumber
    $sql = "SELECT * FROM Students WHERE EnrollmentNumber = '$enrollment' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        // Check if created password matches
        if (password_verify($createdpassword, $student['CreatedPassword'])) {
            // Password correct, start session
            $_SESSION['StudentID'] = $student['StudentID'];
            $_SESSION['FullName'] = $student['FullName'];
            $_SESSION['EnrollmentNumber'] = $student['EnrollmentNumber'];

            // Redirect immediately to another page, e.g., dashboard.php
            header("Location: ../admissions.html");
            exit(); // important to stop further execution
        } else {
            // Redirect to login page with error message
            $_SESSION['login_error'] = "Incorrect Created Password!";
            header("Location: ../login_error.html");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Incorrect Created Password!";
        header("Location: ../login_error.html");
        exit();

    }

    mysqli_close($conn);
} else {
    header("Location: ../login1.html"); // if someone opens the PHP directly
    exit();
}
?>
 