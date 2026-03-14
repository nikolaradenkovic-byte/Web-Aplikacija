<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['id'];
$_SESSION['page'] = "search";

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
    <link rel="stylesheet" href="style.css">
    <title>Pretrazivanje</title>
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
    <div class="wrapper">
        <div class = "pesme">
            <?php
                if(isset($_POST['dodajPesmu'])) {
                    $query = "SELECT * FROM songs WHERE 1=1";
                    if(isset($_POST['songName'])) {
                        $songName = $_POST['songName'];
                        $songName = mysqli_real_escape_string($conn, $songName);
                        $query .= " AND songName LIKE '%$songName%'";
                    }
                    if(isset($_POST['author'])) {
                        $author = $_POST['author'];
                        $author = mysqli_real_escape_string($conn, $author);
                        $query .= " AND author LIKE '%$author%'";
                    }
                    if(isset($_POST['genre'])) {
                        $genre = $_POST['genre'];
                        $genre = mysqli_real_escape_string($conn, $genre);
                        $query .= " AND genre LIKE '%$genre%'";
                    }
                    $result = mysqli_query($conn, $query);
                    if($result) {
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $songPath = mysqli_real_escape_string($conn, $row['songPath']);
                                $songId = $row['id'];
                                echo "<br>";
                                echo "<table>";
                                echo "<tr class=\"row\">";
                                echo "<th>".$row["songName"]."</th>"."<th>".$row["author"]."</th>"."<th>".$row["genre"]."</th>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td colspan=\"3\"><button onclick=\"playSong('./$songPath', $songId)\">Play</button></td>";
                                echo "</tr>";
                                echo "<tr>"; 
                                echo "<td colspan =\"3\">";
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
                            }
                        } else {
                            echo "No songs found...";
                        }
                    }
                }
            ?>
        </div>
        <div class="form-box active">
            <form action="search.php" method="post" enctype="multipart/form-data">
                <h2>Pretrazi Pesme</h2>
                <input type="text" name="songName" title="Napisi ime pesme." placeholder="Ime pesme">
                <input type="text" name="author" title="Napisi ime autora." placeholder="Autor">
                <input type="text" name="genre" title="Napisi zanr." placeholder="Zanr">
                <button type="submit" name="dodajPesmu">Pretrazi</button>
            </form>
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