<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$userId = $_SESSION['id'];

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
    <title>Playlist</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body style="background: #fff;">
    <div class = "wrapper">
        <p class = "header"><a href="./user_page.php">Home</a></p>
        <?php 
            if($_SESSION['role'] == "admin") {
                echo "<p class = \"header\"> <a href=\"./admin_page.php\">Admin Page</a></p>";
            }
        ?>
    </div>
    <div class="playlistWrap">
        <?php
        $result = $conn->query("SELECT * FROM `playlist` WHERE userId = $userId");

        foreach ($result as $playlist) {
            $playlistName = $playlist['name'];
            $playlistId = $playlist['id'];
            echo "<div class=\"playlist\">";
            echo "<p><span>$playlistName</span></p>";
            $pesme = $conn->query("SELECT * FROM `playlistsongs` WHERE playlistId = $playlistId");
            foreach ($pesme as $pesma) {
                $songId = $pesma['songId'];
                $song = $conn->query("SELECT * FROM songs WHERE id = $songId");
                $songRow = $song->fetch_assoc();
                

                    $songPath = $songRow['songPath'];
                    $name = $songRow['songName'];
                    $author = $songRow['author'];
                    $genre = $songRow['genre'];
                    $views = $songRow['views'];

                    $songId = mysqli_real_escape_string($conn, $songRow['id']);
                    $songPath = mysqli_real_escape_string($conn, $songPath);

                echo "<br>";
                echo "<table>";
                echo "<tr class=\"rows\">";
                echo "<th>".$name."</th>"."<th>".$author."</th>"."<th>".$genre."</th>"."<th>".$views."</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan=\"4\"><button onclick=\"playSong('./$songPath', $songId)\">Play</button></td>";
                echo "</tr>";
                echo "</table>";
                echo "<br>";                
            }
            echo "<form action=\"deletePlaylist.php\" method=\"post\">";
            echo "<input type=\"text\" name=\"id\" value=\"$playlistId\" hidden>";
            echo "<button type=\"submit\" class=\"deletePlaylist\">Obrisi Playlistu</button>";
            echo "</form>";
            echo "</div>";   
        }
        ?>
        </div>
        <div class="form-box active">
        <form action="createPlaylist.php" method="post">
            <input type="text" name="playlistName" placeholder="Playlist Name">
            <button type="submit" name="createPlaylist" >Napravi Playlistu</button>
        </form>
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