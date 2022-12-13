<?php session_start();
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

$songs = pg_query($conn, "SELECT * FROM songs") or die;
$song = pg_fetch_all($songs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Playlists</title>
    <link rel="icon" href="../../assets/ONDAicon.svg">
    <link rel="stylesheet" href="../../CSS/style.css">
    <link href="https://api.fontshare.com/v2/css?f[]=nippo@200,300,500,700,400&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=boxing@400&display=swap" rel="stylesheet">
</head>
<body class="ouvinte">
<main class="container" id="biblioteca">
    <nav class="sidenav">
        <a href="../index.php"><img src="../../assets/logoONDA_fundoclaro.svg" width="150" height="" alt="logo"></a>
        <?php
        $userlogged = $_SESSION['username'];
        echo "<h3 style='text-transform: uppercase'>$userlogged's ONDA</h3>";
        ?>

        <div class="dropdown" id="bibliodrop">
            <button class="ouvintesbtn" id="bibliobtn">Biblioteca</button>
            <div class="dropdown-content" id="biblionav">
                <a href="./all.php" class="ouvintelink">Todas as músicas</a>
                <a href="./playlists.php" class="ouvintelink">Playlists</a>
                <a href="./favorites.php" class="ouvintelink">Favoritas</a>
            </div>
        </div>

        <a href="#">
            <button class="ouvintesbtn">Novos Lançamentos</button>
        </a>

        <div class="dropdown" id="pessoaldrop">
            <button class="ouvintesbtn" id="pessoalbtn">Área Pessoal</button>
            <div class="dropdown-content" id="pessoalnav">
                <a href="#" class="ouvintelink">Estatísticas</a>
                <a href="#" class="ouvintelink">Definições</a>
                <a href="../../incPHP/logout.php" class="ouvintelink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="biblioteca" id="playlists">
        <h1>Biblioteca</h1>
        <h2>Playlists</h2>
        <button class="ouvintesbtn" id="newplaylist"">﹢ Criar nova playlist</button>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th><h3>Nome</h3></th>
                    <th><h3>Autor</h3></th>
                    <th><h3>Géneros</h3></th>
                    <th><h3>Adicionada</h3></th>
                </tr>
                <tr>
                    <?php
                    foreach ($song as $s) {
                        $artist = $s['artist'];
                        $artists = pg_query($conn, "SELECT * FROM artists WHERE username = '$artist'") or die;
                        $artist = pg_fetch_array($artists);

                        $album = $s['album'];
                        $albums = pg_query($conn, "SELECT * FROM albums WHERE id = $album") or die;
                        $album = pg_fetch_array($albums);

                        echo "<tr><td>" . $s['title'] . "</td>";
                        echo "<td>" . $s['artist'] . "</td>";
                        echo "<td>" . $s['genre'] . "</td>";
                        echo "<td>" . $s['added'] . "</td></tr>";
                    }
                    ?>
                </tr>
            </table>
        </div>
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>