<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['songId']) && isset($_POST['playlistId'])) {

    $songId = intval($_POST['songId']);
    $playlistId = intval($_POST['playlistId']);

    if ($playlistId == 0) {
        header("Location: playlists.php");
        exit();
    }


    $checkStmt = $conn->prepare("SELECT * FROM playlistsongs WHERE playlistId = ? AND songId = ?");
    if($checkStmt == false) {
        die($conn->error);
    }
    $checkStmt->bind_param("ii", $playlistId, $songId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO playlistsongs (playlistId, songId) VALUES (?, ?)");
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ii", $playlistId, $songId);
        $stmt->execute();
    }

    if($_SESSION['page'] == "search") {
        header("Location: search.php");
        exit();
    }

    if($_SESSION['page'] == "user") {
        header("Location: user_page.php");
        exit();
    }

}
?>