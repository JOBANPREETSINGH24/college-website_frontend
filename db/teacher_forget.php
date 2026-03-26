<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $employeeId = $_POST['EmployeeId'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check password match
    if ($newpassword !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if teacher exists
    $check = mysqli_query($conn, "SELECT * FROM teacher 
                                 WHERE Email='$email' 
                                 AND EmployeeID='$employeeId'");

    if (mysqli_num_rows($check) == 0) {
        echo "No teacher found with this Email and ID!";
        exit();
    }

    // Update password (NO HASH)
    $update = mysqli_query($conn, "UPDATE teacher 
                                  SET Password='$newpassword' 
                                  WHERE Email='$email' 
                                  AND EmployeeID='$employeeId'");

    if ($update) {
        echo "Password updated successfully! You can now login.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);

} else {
    echo "Please submit the form!";
}
?>