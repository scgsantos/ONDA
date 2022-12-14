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
        pg_query($conn, "UPDATE songs SET title='$title' WHERE id = $song_id");

        header("location: ../artista/biblioteca.php");
        exit();
    }
}

else if (isset($_GET['id'])) {
    $song_id = $_GET['id'];
    header("Location: ../artista/biblioteca.php?edit&id=" . $song_id);
    exit();
}
