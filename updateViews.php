<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"];
$result = $conn->query("UPDATE songs SET views = views + 1 WHERE id = $id");
?>