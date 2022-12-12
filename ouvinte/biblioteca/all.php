<?php session_start();
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

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
    <link rel="stylesheet" href="../../CSS/style.css">
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

    <section class="biblioteca" id="all">
        <h1>Biblioteca</h1>
        <h2>Todas as músicas</h2>

        <form method="post" action="../../incPHP/pesquisarlista.php">
            <input name="search" type="text" placeholder="Pesquisar por título ou artista">
            <button type="submit" name="searchlist" class="ouvintesbtn">Pesquisar</button>
        </form>
        <?php
        echo '<p class="error">' . $error . '</p>';
        ?>

        <form method="post" action="../../incPHP/ordenarlista.php">
            <p>Ordenar por</p>
            <fieldset>
                <label><input type="radio" name="sort" value="title">título</label>
                <label><input type="radio" name="sort" value="genre">género</label>
                <label><input type="radio" name="sort" value="added">data de adição</label>
            </fieldset>
            <fieldset>
                <label><input type="radio" name="order" value="asc">ascendente</label>
                <label><input type="radio" name="order" value="desc">descendente</label>
            </fieldset>
            <button type="submit" name="sortlist" class="ouvintesbtn">Ordenar</button>
        </form>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th><h3>Título</h3></th>
                    <th><h3>Artista</h3></th>
                    <th><h3>Álbum</h3></th>
                    <th><h3>Género</h3></th>
                    <th><h3>Adicionada</h3></th>
                    <th><img src="../../assets/favorite.svg" alt=""></th>
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
        </div>
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>