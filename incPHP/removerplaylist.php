<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_GET['id'])) {
    $playlist_id = $_GET['id'];

    pg_query($conn, "DELETE FROM playlist_song WHERE playlist = $playlist_id");
    pg_query($conn, "DELETE FROM playlists WHERE id = $playlist_id");

    header("location: ../ouvinte/biblioteca/playlists.php");
    exit();
}
else {
    header("location: ../ouvinte/biblioteca/playlists.php");
    exit();
}