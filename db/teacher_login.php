<?php
session_start();
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $employeeId = $_POST['EmployeeId'] ?? '';
    $password = $_POST['createdpassword'] ?? '';

    // Direct match in SQL (NO HASH, NO CreatedPassword)
    $sql = "SELECT * FROM teacher 
            WHERE EmployeeID = '$employeeId' 
            AND Password = '$password' 
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $teacher = mysqli_fetch_assoc($result);

        // Start session
        $_SESSION['TeacherID'] = $teacher['id'];
        $_SESSION['FullName'] = $teacher['FullName'];
        $_SESSION['EmployeeID'] = $teacher['EmployeeID'];

        header("Location: ../db/teach.php");
        exit();

    } else {
        $_SESSION['login_error'] = "Invalid Teacher ID or Password!";
        header("Location: ../login_error1.html");
        exit();
    }

    mysqli_close($conn);

} else {
    header("Location: ../login2.html");
    exit();
}
?>