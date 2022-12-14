<?php session_start();
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if(!isset($_SESSION['username'])) header("location: ../../landing.php");
else $userlogged = $_SESSION['username'];

$playlists = pg_query($conn, "SELECT * FROM playlists WHERE author = '$userlogged'") or die;
$playlist = pg_fetch_all($playlists);

$error = '';

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
    $song = pg_fetch_all($songs);
}

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

    <section class="biblioteca" id="playlists">
        <h1>Biblioteca</h1>
        <h2>Playlists</h2>

        <a href="../../incPHP/criarplaylist.php?new">
            <button class="ouvintesbtn" id="new">﹢ Criar nova playlist</button>
        </a>

        <div class="table">
            <table>
                <tr>
                    <th><h3>Nome</h3></th>
                    <th><h3>Género</h3></th>
                    <th><h3>Adicionada</h3></th>
                    <th><h3></h3></th>
                </tr>
                <tr>
                    <?php
                    foreach ($playlist as $p) {
                        echo "<tr><td>" . $p['name'] . "</td>";
                        echo "<td style='text-transform: capitalize'>" . $p['genre'] . "</td>";
                        echo "<td>" . $p['created'] . "</td>";
                        $p_id = $p['id'];
                        $href = '../../incPHP/removerplaylist.php?remove&id=' . $p_id;
                        echo '<td><a href="'.$href.'">
                                <button class="ouvintesbtn" id="remove">REMOVER</button></a></td></tr>';
                    }
                    ?>
                </tr>
            </table>
        </div>

    <?php
    if (isset($_GET['new'])) {
            echo '<div id="popup-content">
                <a class="close" style="font-size: 2rem" href="./playlists.php">×</a>
                <h2>Criar nova playlist</h2>';

                if (!isset($_GET['mode'])) {
                    echo '<form id="playlistmode" action="../../incPHP/criarplaylist.php" method="post"></form>
                          <label><input form="playlistmode" type="radio" name="mode" value="manual" />Manual</label>
                          <label><input form="playlistmode" type="radio" name="mode" value="random" />Aleatória</label>
                          <button form="playlistmode" type="submit" name="playlistmode" class="ouvintesbtn">⏎</button>';
        }

        if (isset($_GET['mode'])) {
            if ($_GET['mode'] == 'manual') {
                echo '<p>(podes selecionar as músicas a adicionar à tua playlist)</p>
                      <form id="newplaylist" action="../../incPHP/criarplaylist.php?mode=manual" method="post"></form>
                      <form id="searchlist" action="../../incPHP/pesquisarlista.php?op=newplst" method="post"></form>
                      
                      <label>Nome<input form="newplaylist" type="text" name="pname" placeholder="inserir nome da playlist" /></label><br>
                      <p>Músicas</p>    
                      <label><input form="searchlist" name="search" type="text" placeholder="Pesquisar por título ou artista" /></label>
                      <button form="searchlist" type="submit" name="searchlist" class="ouvintesbtn">⏎</button>
                      <p style="text-align: left" class="error">' . $error . '</p>';

                if (isset($_GET['search'])) {
                    $action = '../../incPHP/criarplaylist.php?search=' . $search;
                    echo '<form id="selectsongs" action="' . $action . '" method="post"></form>';
                    foreach ($song as $s) {
                        $song_title = $s['title'];
                        $song_id = $s['id'];

                        $artist = $s['artist'];
                        $artists = pg_query($conn, "SELECT * FROM artists WHERE username = '$artist'") or die;
                        $artist = pg_fetch_array($artists);

                        echo '<label>' . $song_title . ' (' . $artist['name'] . ')<input form="selectsongs" type="radio" name="songs" value="' . $song_id . '" /></label><br>';
                    }
                    echo '<button form="selectsongs" type="submit" name="selectsongs" class="ouvintesbtn">Adicionar</button><br>';
                }
                if (isset($_GET['song'])) {
                    $selected_song = $_GET['song'];
                    array_push($_SESSION['selected'], $selected_song);
                }

                foreach($_SESSION['selected'] as $s) {
                    $title = pg_query($conn, "SELECT title FROM songs WHERE id = $s") or die;
                    $t = pg_fetch_array($title);

                    $artist = pg_query($conn, "SELECT artist FROM songs WHERE id = $s") or die;
                    $a = pg_fetch_array($artist);
                    $a_user = $a['artist'];
                    $artist_name = pg_query($conn, "SELECT name FROM artists WHERE username= '$a_user'") or die;
                    $a_name = pg_fetch_array($artist_name);

                    echo $t['title'] .' ('. $a_name['name'] . ')<br>';
                }

                echo '<button form="newplaylist" type="submit" name="newplaylist" class="ouvintesbtn">Criar</button>';
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyfields") echo "<p class='error'>Preencha todos os campos</p>";
                }

            } else if ($_GET['mode'] == 'random') {
                echo '<p>(podes selecionar o género musical e o número de músicas que pretendes e a tua playlist é criada aleatoriamente)</p>
                      <form id="newplaylist" action="../../incPHP/criarplaylist.php?mode=random" method="post"></form>
                      <label>Nome<input form="newplaylist" type="text" name="pname" placeholder="inserir nome da playlist" /></label><br>
                      <label>Género<input form="newplaylist" type="text" name="genre" placeholder="inserir género da playlist" /></label><br>
                      <label>Número de músicas<input form="newplaylist" type="number" name="songsnum" placeholder="" /></label><br>
                      <button form="newplaylist" type="submit" name="newplaylist" class="ouvintesbtn">Criar</button>';
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyfields") echo "<p class='error'>Preencha todos os campos</p>";
                }
            }
        }
    }

    else if (isset($_GET['remove'])) {
        $p_id = $_GET['id'];
        $href = '../../incPHP/removerplaylist.php?id=' . $p_id . '&yes';
        echo '<div id="popup-content">
                <h3>Tens a certeza que pretendes remover esta playlist?</h3>
                
                <a href="'.$href.'"><button class="ouvintesbtn">Sim</button></a>
                <a href="./playlists.php"><button class="ouvintesbtn">Cancelar</button></a>';
    }

    ?>
    </section>

</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>