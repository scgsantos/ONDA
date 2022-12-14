<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_POST['editsong'])) {
    $title = $_POST['title'];
    $song_id = $_GET['id'];

    if (empty($title) !== false) {
        header("location: ../artista/biblioteca.php?edit&id=" . $song_id . "&error=emptyfields");
        exit();
    } else {

        echo $title;
        echo $song_id;

        //$song = pg_query($conn, "SELECT * FROM songs WHERE id = $song_id");
        //$s = pg_fetch_array($song);

        //$title = $s['title'];
        //$album_id = $s['album'];

        //$album_title = pg_query($conn, "SELECT title FROM albums WHERE id = $album_id");
        //$a_title = pg_fetch_array($album_title);
        //$album = $a_title['title'];

        pg_query($conn, "UPDATE songs SET title='$title' WHERE id = $song_id");

        //if ($title != $album) {
        //}

        header("location: ../artista/biblioteca.php");
        exit();
    }
}

else if (isset($_GET['id'])) {
    $song_id = $_GET['id'];
    header("Location: ../artista/biblioteca.php?edit&id=" . $song_id);
    exit();
}
