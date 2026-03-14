<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$userId = $_SESSION['id'];
$_SESSION['page'] = "user";
?>

<?php 
    $svePesme = $conn->query("SELECT * FROM `songs`");
    $listaPesmi = array();

    while($row = $svePesme->fetch_assoc()) {
        $listaPesmi[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body style="background: #fff;">
    <div class = "wrapper">
        <p class = "header"><a href="./playlists.php">Playlists</a></p>
        <p class = "header"><a href="./search.php">Search</a></p>
        <?php 
            if($_SESSION['role'] == "admin") {
                echo "<p class = \"header\"> <a href=\"./admin_page.php\">Admin Page</a></p>";
            }
        ?>
    </div>
    <div class = "wrapper">
        <div class = "pesme">
        <?php

        $result = $conn->query("SELECT * FROM songs");

        foreach ($result as $song) {
            $songPath = $song['songPath'];
            $name = $song['songName'];
            $author = $song['author'];
            $genre = $song['genre'];
            $views = $song['views'];

            $songId = mysqli_real_escape_string($conn, $song['id']);
            $songPath = mysqli_real_escape_string($conn, $songPath);

            echo "<br>";
            echo "<table>";
            echo "<tr class=\"row\">";
            echo "<th>".$name."</th>"."<th>".$author."</th>"."<th>".$genre."</th>"."<th>".$views."</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan=\"4\"><button onclick=\"playSong('./$songPath', $songId)\">Play</button></td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td colspan =\"4\">";
            $plejliste = $conn->query("SELECT * FROM `playlist` WHERE userId = $userId");
            echo "<form method='POST' action='addPlaylistSong.php'>";
            echo "<input type='hidden' name='songId' value='$songId'>";    
            echo "<select name='playlistId' onchange='this.form.submit()'>";
            echo "<option value=\"\" disabled selected hidden>Dodaj u playlistu</option>";
            if(mysqli_num_rows($plejliste) <= 0){
                echo "<option value=\"0\">Napravi Playlistu</option>";
            }
            foreach ($plejliste as $pl) {
                echo "<option value='{$pl['id']}'>{$pl['name']}</option>";
            }
            echo "</select>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<br>";  
            
        }
        ?>
        </div>
        
        <div class="box">
            <h1>Zdravo, <span><?= $_SESSION['name']; ?></span></h1>
            <p>Ovo je <span>korisnicka</span> stranica</p>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
    <audio class="audioPlayer" id="audioPlayer" controls>
        <source id="source" src="" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
            <script src="./player.js"></script>
            <script>
                let listaPesama = <?php echo json_encode($listaPesmi); ?>;
                let audioPlayer1 = document.getElementById("audioPlayer");
                const source1 = document.getElementById('source');

                audioPlayer1.addEventListener("ended", function() {
                    let nextSong;
                    do {
                        nextSong = listaPesama[Math.floor(Math.random() * listaPesama.length)];
                    } while (nextSong.songPath === decodeURIComponent(new URL(source1.src).pathname).replace('/PVA/', ''));
          
                    playSong("./"+nextSong.songPath, nextSong.id);

                });
            </script>
</body>
</html>