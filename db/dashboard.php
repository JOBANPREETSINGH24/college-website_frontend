<?php
session_start();

if(!isset($_SESSION['StudentID'])) {
    header("Location: ssignin.html");
    exit();
}
?>

<h1>Welcome <?php echo $_SESSION['FullName']; ?>!</h1>
<p>You are logged in with Enrollment Number: <?php echo $_SESSION['StudentID']; ?></p>
<a href="logout.php">Logout</a>
