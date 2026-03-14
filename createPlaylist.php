<?php 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once 'config.php';

if (isset($_POST['createPlaylist'])) {
    $userId = $_SESSION['id'];
    $playlistName = $_POST['playlistName'];
    $conn->query("INSERT INTO playlist (userId, name) VALUES ('$userId', '$playlistName')");
}

header("Location: playlists.php")

?>