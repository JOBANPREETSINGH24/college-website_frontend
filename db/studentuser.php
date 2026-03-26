<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO studentuser (Email, Password)
            VALUES ('$email', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {

        // Set session after registration
        $_SESSION['student_email'] = $email;

        header("Location: ../aform.html");
        exit();

    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>