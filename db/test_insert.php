<?php
include "db_connect.php";

$sql = "INSERT INTO students (FullName, Email, Password, EnrollmentNumber)
        VALUES ('Test User', 'test@example.com', '1234', '12345')";

if (mysqli_query($conn, $sql)) {
    echo "Inserted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
