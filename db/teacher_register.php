<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
var_dump($_POST); // show what form sent
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $createpassword = $_POST['createpassword'] ?? '';
    $enrollment = $_POST['EnrollmentNumber'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);         // original password
    
    $hashedCreatedPassword = password_hash($createpassword, PASSWORD_DEFAULT); // created password


$sql = "INSERT INTO Students (FullName, Email, Password, EnrollmentNumber, CreatedPassword)
        VALUES ('$fullname', '$email', '$hashedPassword', '$enrollment', '$hashedCreatedPassword')";


    if (mysqli_query($conn, $sql)) {
    header("Refresh:2; url=../login1.html"); 
    echo "Student registered successfully. Redirecting to login...";
    exit();
    }
    else {
        echo "DB Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "No form submitted!";
}
?>
