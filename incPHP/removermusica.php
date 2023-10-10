<?php
$str = "dbname=railway user=postgres password=A1wgDErIGszzRn96AAML host=containers-us-west-141.railway.app port=6790";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_GET['remove'])) {
    if (isset($_GET['id'])) {
        $song_id = $_GET['id'];
        header("location: ../artista/biblioteca.php?remove&id=$song_id");
    }
}

else if (isset($_GET['yes'])) {
    $song_id = $_GET['id'];
    $album_id = pg_query($conn, "SELECT album FROM songs WHERE id = '$song_id'");
    $a_id = pg_fetch_array($album_id);
    $a = $a_id['album'];

    $result = pg_query($conn, "SELECT album FROM songs WHERE album='$a'");
    $rows = pg_num_rows($result);

    pg_query($conn, "DELETE FROM playlist_song WHERE song = '$song_id'");
    pg_query($conn, "DELETE FROM songs WHERE id = '$song_id'");

    if ($rows == 1) {
        pg_query($conn, "DELETE FROM albums WHERE id = $a");
    }
    header("location: ../artista/biblioteca.php");
    exit();
}