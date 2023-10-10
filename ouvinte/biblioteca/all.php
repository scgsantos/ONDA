<?php
session_start();
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if(!isset($_SESSION['username'])) header("location: ../../index.php");
else $userlogged = $_SESSION['username'];

$songs = pg_query($conn, "SELECT * FROM songs") or die;
$error = '';

// ordenar lista
if (isset($_GET["sort"], $_GET["order"])) {
    $sort = $_GET['sort'];
    $order = $_GET['order'];

    $songs = pg_query($conn, "SELECT * FROM songs ORDER BY $sort $order ") or die;
}

// pesquisar lista
if (isset($_GET["search"])) {
    $search = $_GET['search'];

    // por título
    $condition1 = "title ILIKE '%$search%'";

    // por artista
    $artists = pg_query($conn, "SELECT * FROM artists WHERE name ILIKE '%$search%'") or die;
    $artist = pg_fetch_all($artists);
    $a_user = array();
    foreach ($artist as $a) array_push($a_user, $a['username']);
    $arr = "('" . implode("', '", $a_user) . "')";
    $condition2 = "artist IN $arr";

    $songs = pg_query($conn, "SELECT * FROM songs WHERE $condition1 OR $condition2") or die;
    if (pg_num_rows($songs) == 0) $error = 'Não foram encontrados resultados';
}

$song = pg_fetch_all($songs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Todas as músicas</title>
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
            </div>
        </div>

        <div class="dropdown" id="pessoaldrop">
            <button class="ouvintesbtn" id="pessoalbtn">Área Pessoal</button>
            <div class="dropdown-content" id="pessoalnav">
                <a href="#" class="ouvintelink">Definições</a>
                <a href="../../incPHP/logout.php" class="ouvintelink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="biblioteca" id="all">
        <h1>Biblioteca</h1>
        <h2>Todas as músicas</h2>

        <div class="controls">
            <form class="searchlist" method="post" action="../../incPHP/pesquisarlista.php?op=all">
                <input name="search" type="text" placeholder="Pesquisar por título ou artista">
                <button type="submit" name="searchlist" class="ouvintesbtn">⏎</button>
                <?php
                echo '<p style="text-align: left" class="error">' . $error . '</p>';
                ?>
            </form>

            <form class="sortlist" method="post" action="../../incPHP/ordenarlista.php">
                <b>Ordenar por:</b>
                <div>
                    <fieldset>
                        <label><input type="radio" name="sort" value="title">título</label>
                        <label><input type="radio" name="sort" value="genre">género</label>
                        <label><input type="radio" name="sort" value="added">data de adição</label>
                    </fieldset>
                    <fieldset>
                        <label><input type="radio" name="order" value="asc">ascendente</label>
                        <label><input type="radio" name="order" value="desc">descendente</label>
                    </fieldset>
                </div>
                <button type="submit" name="sortlist" class="ouvintesbtn">⏎</button>
            </form>
        </div>

            <table>
                <tr>
                    <th><h3>Título</h3></th>
                    <th><h3>Artista</h3></th>
                    <th><h3>Álbum</h3></th>
                    <th><h3>Género</h3></th>
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
                        echo "<td>" . $artist['name'] . "</td>";
                        echo "<td>" . $album['title'] . "</td>";
                        echo "<td>" . $s['genre'] . "</td>";
                        echo "<td>" . $s['added'] . "</td></tr>";
                    }
                    ?>
                </tr>
            </table>
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>