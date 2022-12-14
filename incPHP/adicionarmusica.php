<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_POST['newsong'])) {
    $genre = $_POST['genre'];
    $title = $_POST['title'];
    $album = $_POST['album'];

    if ((is_null($genre) || empty($title) || empty($album)) !== false) {
        header("location: ../artista/biblioteca.php?new&error=emptyfields");
        exit();
    }
    else {
        $artist = $_SESSION['username'];
        $date = date("Y-m-d");

        if($album == 'no_album') {
            pg_query($conn, "INSERT INTO albums (title, artist) VALUES ('$title', '$artist')");

            $album_id = pg_query($conn, "SELECT id FROM albums WHERE title='$title'");
            $a_id = pg_fetch_array($album_id);
            $a_id = $a_id['id'];

            pg_query($conn, "INSERT INTO songs (title, genre, added, artist, album) VALUES ('$title', '$genre', '$date', '$artist', '$a_id')");

            header("Location: ../artista/biblioteca.php");
            exit();
        }
        else {
            $album_id = pg_query($conn, "SELECT id FROM albums WHERE title='$album'");

            $rows = pg_num_rows($album_id);
            if ($rows < 1) {
                pg_query($conn, "INSERT INTO albums (title, artist) VALUES ('$album', '$artist')");
                $album_id = pg_query($conn, "SELECT id FROM albums WHERE title='$album'");
            }

            $a_id = pg_fetch_array($album_id);
            $a_id = $a_id['id'];

            pg_query($conn, "INSERT INTO songs (title, genre, added, artist, album) VALUES ('$title', '$genre', '$date', '$artist', '$a_id')");

            header("Location: ../artista/biblioteca.php");
            exit();
        }

    }
}
else if (isset($_GET['new'])) {
    header("Location: ../artista/biblioteca.php?new");
    exit();
}

else {
    header("Location: ../artista/biblioteca.php");
    exit();
}