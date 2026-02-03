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

    // Verify teacher exists
    $sql_check = "SELECT * FROM teachers WHERE Email = '$email' AND EmployeeID = '$enrollment'";
    $result = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result) === 0) {
        echo "No teacher found with this Email and Employee ID!";
        exit();
    }

    // Hash the new password
    $hashedCreatedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

    // Update the CreatedPassword column
    $sql_update = "UPDATE teachers 
                   SET CreatedPassword = '$hashedCreatedPassword'
                   WHERE EmployeeID = '$enrollment' AND Email = '$email'";

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

