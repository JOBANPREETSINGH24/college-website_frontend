<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $enrollment = trim($_POST['EnrollmentNumber']);
    $newpassword = trim($_POST['newpassword']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check password match
    if ($newpassword !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if user exists
    $sql_check = "SELECT * FROM student 
                  WHERE Email='$email' 
                  AND EnrollmentNumber='$enrollment'";

    $result = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result) == 0) {
        echo "No student found with this Email and Enrollment Number!";
        exit();
    }

    // Update password WITHOUT hashing
    $sql_update = "UPDATE student 
                   SET Password='$newpassword' 
                   WHERE Email='$email' 
                   AND EnrollmentNumber='$enrollment'";

    if (mysqli_query($conn, $sql_update)) {
        echo "Password updated successfully! You can now login.";
    } else {
        echo "DB Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);

} else {
    echo "Please submit the form!";
}
?>