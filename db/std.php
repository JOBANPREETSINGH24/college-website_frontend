<?php
session_start();

// STOP CACHE (very important)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// If student not logged in, redirect to login page
if (!isset($_SESSION['StudentID'])) {
    header("Location: ../login1.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="SGAD College Khadur Sahib - Excellence in education, innovation, and research.">

    <title>SGAD College</title>

    <link rel="icon" type="image/png" href="images/a1111.png">

    <link rel="stylesheet" href="../css/std.css?v=2"> // Cache busting by adding version query parameter

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../images/a111.png" alt="College Logo">
            </div>

            <div class="header-text">
                <h1>ਸ਼੍ਰੀ ਗੁਰੂ ਅੰਗਦ ਦੇਵ ਕਾਲਜ ਖਡੂਰ ਸਾਹਿਬ</h1>
                <h2>SGAD College Khadur Sahib</h2>
            </div>

            <div class="logo1">
                <img src="../images/5-removebg-preview.png" alt="GNDU Logo">
                <p>Affiliated to GNDU Amritsar</p>
            </div>
        </div>
    </header>

    <!-- NAVBAR -->
    <nav>
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">LOGOUT</a>
    </nav>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "college_db");

    if (!$conn) {
        die("Database not connected");
    }

    $data = mysqli_query($conn, "SELECT * FROM teacher_images ORDER BY id DESC");
    ?>

    <section class="teacher-messages">
        <h2>Teacher Image Messages</h2>

        <?php
        if (mysqli_num_rows($data) > 0) {
            while ($row = mysqli_fetch_assoc($data)) {
        ?>
                <div class="msg-box">
                    <small>Uploaded on: <?php echo $row['uploaded_at']; ?></small><br>

                    <img src="../uploads/<?php echo $row['image_name']; ?>" 
                         alt="Teacher Image"
                         width="1400px" height="auto"
                         style="display:block;margin:auto;"><br>
                </div>
        <?php
            }
        } else {
            echo "<p style='text-align:center;color:red;'>No Images Uploaded Yet</p>";
        }
        ?>
    </section>

    <!-- FOOTER SECTION -->
    <section class="bottom-info">
        <div class="col-1">
            <h5 style="font-size: 30px; font-weight: bold;"> USEFUL LINKS</h5>
            <a href="index.html">HOME</a>
            <a href="about.html" target="_blank">ABOUT</a>
            <a href="admissions.html" target="_blank">ADMISSION</a>
            <a href="courses.html" target="_blank">COURSES</a>
            <a href="contact.html" target="_blank">CONTACT</a>
        </div>

        <div class="col-3">
            <h5 style="font-size: 30px; font-weight: bold;">CONTACT</h5>
            <p>Sri Guru Angad Dev College Khadur Sahib,<br> Distt-Tarn Taran, Punjab, India</p>

            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>

                <a href="https://www.twitter.com" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>

                <a href="https://www.instagram.com/sgadcollege?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                    target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>

        <div class="col-2">
            <img src="../images/a111.png" width="200px" class="rounded-img">
        </div>
    </section>

    <footer>
        &copy; 2025 Sri Guru Angad Dev College Khadur Sahib | All Rights Reserved
    </footer>

</body>

</html>
