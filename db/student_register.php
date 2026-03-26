<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF); // stop fatal error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = trim($_POST['username']);
    $email = trim($_POST['email']);
    $enrollment = trim($_POST['EnrollmentNumber']);
    $password = trim($_POST['password']);

    if (strlen($enrollment) != 5 || !is_numeric($enrollment)) {
        echo "<script>alert('Employee ID must be exactly 5 digits'); window.location='../login1.html';</script>";
        exit();
    }

    // Check existing user
    $check = mysqli_query($conn, "SELECT * FROM student WHERE Email='$email' OR EnrollmentNumber='$enrollment'");

    if (mysqli_num_rows($check) > 0) {
        echo "User already exists!";
        exit();
    }

    // Insert data WITHOUT hashing
    $sql = "INSERT INTO student (FullName, Email, EnrollmentNumber, Password)
            VALUES ('$fullname', '$email', '$enrollment', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../login1.html");
        exit();
    } else {
        header("Location: ../alreadyexist.html");
        exit();
    }

    mysqli_close($conn);
} else {
    echo "No form submitted!";
}
