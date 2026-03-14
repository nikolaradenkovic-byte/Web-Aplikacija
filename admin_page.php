<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if($_SESSION['role'] == "user") {
    header("Location: user_page.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body style="background: #fff;">
    <div class = "wrapper">
        <p class = "header"><a href="./user_page.php">Home</a></p>
    </div>
        <div class="container">
            <div class="form-box active">
                <form action="addSong.php" method="post" enctype="multipart/form-data">
                    <h2>Dodaj Pesmu</h2>
                    <input type="text" name="songName" title="Napisi ime pesme." placeholder="Ime pesme" required>
                    <input type="text" name="author" title="Napisi ime autora." placeholder="Autor" required>
                    <input type="text" name="genre" title="Napisi zanr." placeholder="Zanr" required>
                    <input type="text" name="album" title="Koji je album?" placeholder="Album" required>
                    <input type="file" name="pesma" accept=".mp3" required>
                    <button type="submit" name="dodajPesmu">Dodaj</button>
                </form>
            </div>
        </div>

        <div class="box">
            <h1>Dobrodosao, <span><?= $_SESSION['name']; ?></span></h1>
            <p>Ovo je <span>admin</span> stranica.</p>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>

</body>
</html>