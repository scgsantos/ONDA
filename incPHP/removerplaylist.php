<?php
$str = "dbname=railway user=postgres password=A1wgDErIGszzRn96AAML host=containers-us-west-141.railway.app port=6790";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_GET['remove'])) {
    if (isset($_GET['id'])) {
        $playlist_id = $_GET['id'];
        header("location: ../ouvinte/biblioteca/playlists.php?remove&id=$playlist_id");
    }
}

else if (isset($_GET['yes'])) {
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