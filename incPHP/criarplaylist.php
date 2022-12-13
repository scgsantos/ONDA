<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST['playlistmode'])) {
    $mode = $_POST['mode'];
    if (is_null($mode) !== false) {
        header("location: ../ouvinte/biblioteca/playlists.php?new");
        exit();
    } else {
        header("Location: ../ouvinte/biblioteca/playlists.php?new&mode=$mode");
        exit();
    }
} else if (isset($_POST['newplaylist'])) {
    $name = $_POST['pname'];
    $songs = $_POST['songs'];

    if (isset($_GET['manual'])) {
        if ((empty($name) || empty($songs)) !== false) {
            header("location: ../ouvinte/biblioteca/playlists.php?new&mode=manual");
            exit();
        }
        else {
            header("location: ../ouvinte/biblioteca/all.php");
            exit();
        }
    }
} else {
    header("Location: ../ouvinte/biblioteca/playlists.php?new");
    exit();
}
