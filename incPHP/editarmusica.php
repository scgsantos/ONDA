<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_POST['editsong'])) {
    $author = $_POST['artist'];
    $date = $_POST['added'];
    $genre = $_POST['genre'];
    $title = $_POST['title'];
    $album = $_POST['album'];

    $song_id = $_POST['song_id'];

    pg_query($conn, "UPDATE songs SET title='$title', genre='$genre', added='$date', artist='$author', album='$album') 
             WHERE id = '$song_id'");

    header("location: ../artista/biblioteca.php/");
    exit();
}