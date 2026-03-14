<?php 

require_once 'config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['dodajPesmu'])) {

    $file = $_FILES['pesma'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $allowed = ['mp3'];

    $name = $_POST['songName'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $album = $_POST['album'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, $allowed)) {

        if ($fileError === 0) {

            if ($fileSize < 8000000) {

                $uploadPath = "uploads/" . $fileName;

                move_uploaded_file($fileTmpName, $uploadPath);

                $uploadPath = mysqli_real_escape_string($conn, $uploadPath);
                $name = mysqli_real_escape_string($conn, $name);
                $author = mysqli_real_escape_string($conn, $author);
                $album = mysqli_real_escape_string($conn, $album);
                
                $conn->query("INSERT INTO songs (songPath, songName, author, genre, album) VALUES ('$uploadPath', '$name', '$author', '$genre', '$album')");
                
                echo "Upload successful!";
            } else {
                echo "File too big.";
            }

        } else {
            echo "Upload error.";
        }

    } else {
        echo "Invalid file type.";
    }
}

header("Location: admin_page.php")

?>