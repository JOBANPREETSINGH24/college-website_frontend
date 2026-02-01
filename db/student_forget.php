<?php
include "db_connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $enrollment = $_POST['EnrollmentNumber'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Password match check
    if ($newpassword !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Verify student exists
    $sql_check = "SELECT * FROM Students WHERE Email = '$email' AND EnrollmentNumber = '$enrollment'";
    $result = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result) === 0) {
        echo "No student found with this Email and Enrollment Number!";
        exit();
    }

    // Hash the new password
    $hashedCreatedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

    // Update the CreatedPassword column
    $sql_update = "UPDATE Students 
                   SET CreatedPassword = '$hashedCreatedPassword'
                   WHERE EnrollmentNumber = '$enrollment' AND Email = '$email'";

    if (mysqli_query($conn, $sql_update)) {
        echo "Created password updated successfully! You can now login.";
    } else {
        echo "DB Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);

} else {
    echo "Please submit the form!";
}
?>

