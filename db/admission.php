<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF); // stop fatal error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name       = $_POST['name'] ?? '';
    $mother     = $_POST['mname'] ?? '';
    $father     = $_POST['fname'] ?? '';
    $dob        = $_POST['dob'] ?? '';
    $email      = $_POST['email'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $school     = $_POST['school'] ?? '';
    $percentage = $_POST['percentage'] ?? '';
    $year       = $_POST['year'] ?? '';
    $address    = $_POST['Address'] ?? '';
    $gender     = $_POST['gender'] ?? '';
    $caste      = $_POST['cast'] ?? '';
    $course     = $_POST['Subject'] ?? '';
    $type       = $_POST['Type'] ?? '';

    // INSERT QUERY
    $sql = "INSERT INTO admissions 
    (name, mother_name, father_name, dob, email, phone, school_12th, percentage_12th, passing_year_12th, address, gender, caste, course, course_type)
    
    VALUES 
    ('$name', '$mother', '$father', '$dob', '$email', '$phone', '$school', '$percentage', '$year', '$address', '$gender', '$caste', '$course', '$type')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../success.html");  // create this page
        exit();
    } else {
        header("Location: ../error.html");
        exit();
    }

    mysqli_close($conn);

} else {
    echo "No form submitted!";
}
?>