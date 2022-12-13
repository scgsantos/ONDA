<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");
session_start();

if (isset($_POST['playlistmode'])) {
    $mode = $_POST['mode'];
    if (is_null($mode) !== false) {
        header("location: ../ouvinte/biblioteca/playlists.php?new");
        exit();
    } else {
        header("Location: ../ouvinte/biblioteca/playlists.php?new&mode=$mode");
        exit();
    }

} else if (isset($_POST['selectsongs'])) {
    $songs = $_POST['songs'];

    $search = $_GET['search'];

    if (is_null($songs) !== false) {
        header("Location: ../ouvinte/biblioteca/playlists.php?new&mode=manual&search=$search");
        exit();
    }
    else {
        header("Location: ../ouvinte/biblioteca/playlists.php?new&mode=manual&song=$songs");
        exit();
    }


} else if (isset($_POST['newplaylist'])) {
    $mode = $_GET['mode'];

    if ($mode == 'manual') {

        $name = $_POST['pname'];
        $songs = $_SESSION['selected'];

        if ((empty($name) || empty($songs)) !== false) {
            header("location: ../ouvinte/biblioteca/playlists.php?new&mode=manual&error=emptyfields");
            exit();
        }
        else {
            $author = $_SESSION['username'];
            $date = date("Y-m-d");

            pg_query($conn, "INSERT INTO playlists (name, created, author) VALUES ('$name', '$date', '$author')");
            $playlist_id = pg_query($conn, "SELECT id FROM playlists WHERE name='$name'");
            $p_id = pg_fetch_array($playlist_id);
            $p_id = $p_id['id'];

            foreach($songs as $s) {
                pg_query($conn, "INSERT INTO playlist_song (playlist, song) VALUES ($p_id, $s)");
            }

            $_SESSION['selected'] = array();
            header("location: ../ouvinte/biblioteca/playlists.php");
            exit();
        }
    }
    else if ($mode == 'random') {
        $name = $_POST['pname'];
        $songsnum = $_POST['songsnum'];
        $genre = $_POST['genre'];


        if ((empty($songsnum) || empty($genre)) !== false) {
            header("location: ../ouvinte/biblioteca/playlists.php?new&mode=random&error=emptyfields");
            exit();
        }

        else {
            $author = $_SESSION['username'];
            $date = date("Y-m-d");

            pg_query($conn, "INSERT INTO playlists (name, created, author) VALUES ('$name', '$date', '$author')");

            $song_ids = pg_query($conn, "SELECT id FROM songs WHERE genre='$genre' LIMIT $songsnum OFFSET 0");
            $songs_id = pg_fetch_all($song_ids);
            var_dump($songs_id);

            $playlist_id = pg_query($conn, "SELECT id FROM playlists WHERE name='$name'");
            $p_id = pg_fetch_array($playlist_id);
            $p_id = $p_id['id'];

            foreach($songs_id as $s_ids) {
                $s_id = $s_ids['id'];
                pg_query($conn, "INSERT INTO playlist_song (playlist, song) VALUES ($p_id, $s_id)");
            }
            header("location: ../ouvinte/biblioteca/playlists.php");
            exit();
        }
    }
}

else if (isset($_GET['new'])) {
    header("Location: ../ouvinte/biblioteca/playlists.php?new");
    exit();
}

else {
    $_SESSION['selected'] = array();
    header("Location: ../ouvinte/biblioteca/playlists.php");
    exit();
}
