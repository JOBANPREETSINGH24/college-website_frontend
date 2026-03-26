<?php
session_start();

// STOP CACHE (important)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// If teacher not logged in, redirect to login page
if (!isset($_SESSION['TeacherID'])) {
    header("Location: ../login2.html");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "college_db");

if(!$conn){
    die("Database not connected");
}

// DELETE IMAGE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $get = mysqli_query($conn, "SELECT * FROM teacher_images WHERE id='$id'");
    $row = mysqli_fetch_assoc($get);

    $img = $row['image_name'];

    // delete file from folder
    if(file_exists("../uploads/".$img)){
        unlink("../uploads/".$img);
    }

    // delete from database
    mysqli_query($conn, "DELETE FROM teacher_images WHERE id='$id'");

    header("Location: teach.php");
    exit();
}

// UPDATE IMAGE
if (isset($_POST['update'])) {

    $id = $_POST['id'];

    $get = mysqli_query($conn, "SELECT * FROM teacher_images WHERE id='$id'");
    $row = mysqli_fetch_assoc($get);

    $oldimg = $row['image_name'];

    $newfilename = $_FILES['photo']['name'];
    $tmpname = $_FILES['photo']['tmp_name'];

    if (!is_dir("../uploads")) {
        mkdir("../uploads", 0777, true);
    }

    $folder = "../uploads/" . $newfilename;

    if (move_uploaded_file($tmpname, $folder)) {

        // delete old file
        if (file_exists("../uploads/" . $oldimg)) {
            unlink("../uploads/" . $oldimg);
        }

        mysqli_query($conn, "UPDATE teacher_images SET image_name='$newfilename', uploaded_at=NOW() WHERE id='$id'");

        echo "<script>alert('Image Updated Successfully');</script>";
        header("Location: teach.php");
        exit();
    } 
    else {
        echo "<script>alert('Update Failed');</script>";
    }
}

// UPLOAD IMAGE
if(isset($_POST['upload'])){

    $filename = $_FILES['photo']['name'];
    $tmpname  = $_FILES['photo']['tmp_name'];

    if(!is_dir("../uploads")){
        mkdir("../uploads", 0777, true);
    }

    $folder = "../uploads/" . $filename;

    if(move_uploaded_file($tmpname, $folder)){

        $sql = "INSERT INTO teacher_images(image_name, uploaded_at) 
                VALUES('$filename', NOW())";

        mysqli_query($conn, $sql);

        echo "<script>alert('Uploaded Successfully');</script>";
        header("Location: teach.php");
        exit();
    }
    else{
        echo "<script>alert('Upload Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="SGAD College Khadur Sahib - Excellence in education, innovation, and research.">

    <title>Teacher Upload Page</title>

    <link rel="icon" type="image/png" href="../images/a1111.png">

    <link rel="stylesheet" href="../css/teach.css?v=10">

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
        <hr>
    </header>

    <!-- ========================= -->
    <!-- Teacher Upload Box -->
    <!-- ========================= -->
    <div class="box" >
        <h2 style="font-size: 40px; font-family: italic;">Teacher Upload Image</h2>
        <br>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="photo" required>
            <br><br>
            <button type="submit" name="upload">Upload Image</button>
        </form>
    </div>

    <!-- ========================= -->
    <!-- Uploaded Images Table -->
    <!-- ========================= -->
    <h2 style="text-align:center; margin-top: 30px;font-family: italic ">Uploaded Images</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Date</th>
            <th>Action</th>
            <th>Delete</th>
        </tr>

        <?php
        $data = mysqli_query($conn, "SELECT * FROM teacher_images ORDER BY id DESC");

        if(mysqli_num_rows($data) > 0){
            while($row = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>

            <td>
                <img src="../uploads/<?php echo $row['image_name']; ?>" width="150">
            </td>

            <td><?php echo $row['uploaded_at']; ?></td>

            <td>

                <!-- UPDATE FORM -->
                <form method="POST" enctype="multipart/form-data" style="margin-bottom:10px;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="file" name="photo" required>
                    <br><br>
                    <button type="submit" name="update" class="update-btn">Update</button>
                </form>
            </td>

            <td>
                <!-- DELETE BUTTON -->
                 <p>DELETE FROM HERE</p>
                 <br>
                <a class="delete-btn" href="teach.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete?')">
                   Delete
                </a>

            </td>
        </tr>

        <?php
            }
        }
        else{
            echo "<tr><td colspan='5' style='text-align:center;'>No images uploaded</td></tr>";
        }
        ?>

    </table>

    <br><br>

    <!-- LOGOUT BUTTON -->
    <a href="logout2.php" class="button1" onclick="return confirm('Are you sure you want to logout?')">LOGOUT</a>

    <br><br>

    <!-- ========================= -->
    <!-- Footer Section -->
    <!-- ========================= -->
    <section class="bottom-info">
        <div class="col-1">
            <h5 style="font-size: 30px; font-weight: bold;"> USEFUL LINKS</h5>
            <a href="../index.html">HOME</a>
            <a href="../about.html" target="_blank">ABOUT</a>
            <a href="../admissions.html" target="_blank">ADMISSION</a>
            <a href="../courses.html" target="_blank">COURSES</a>
            <a href="../contact.html" target="_blank">CONTACT</a>
        </div>

        <div class="col-3">
            <h5 style="font-size: 30px; font-weight: bold;">CONTACT</h5>
            <P>Sri Guru Angad Dev College Khadur Sahib,<br> Distt-Tarn Taran,Punjab,India </P>

            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com/sgadcollege" target="_blank">
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
