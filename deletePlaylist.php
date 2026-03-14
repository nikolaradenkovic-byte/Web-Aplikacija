<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$playlistId = $_POST['id'];

$conn->begin_transaction();

    try {
        $stmt1 = $conn->prepare("DELETE FROM playlistsongs WHERE playlistId = ?");
        $stmt1->bind_param("i", $playlistId);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM playlist WHERE id = ?");
        $stmt2->bind_param("i", $playlistId);
        $stmt2->execute();

        $conn->commit();

        header("Location: playlists.php");
        return true;

    } catch (Exception $e) {
        $conn->rollback();
        header("Location: playlists.php");
        return false;
    }

?>