<?php session_start();
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

$playlists = pg_query($conn, "SELECT * FROM playlists") or die;
$playlist = pg_fetch_all($playlists);
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

        <a href="../../incPHP/criarplaylist.php"><button class="ouvintesbtn" id="newplaylist">﹢ Criar nova playlist</button></a>

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
                    foreach ($playlist as $p) {
                        echo "<tr><td>" . $p['name'] . "</td>";
                        echo "<td>" . $p['author'] . "</td>";
                        echo "<td>genres</td>";
                        echo "<td>" . $p['created'] . "</td></tr>";
                    }
                    ?>
                </tr>
            </table>
        </div>
    </section>

    <?php
    if (isset($_GET['new'])) {
        echo '<div id="popup-content">
                <a href="playlists.php">×</a>
                <h2>Nova playlist</h2>
                <form action="../../incPHP/criarplaylist.php" method="post">
                    <label>Manual<input type="radio" name="mode" value="manual"></label>
                    <label>Aleatória<input type="radio" name="mode" value="random"></label>
                    <button type="submit" name="playlistmode" class="ouvintesbtn">⏎</button>
                </form>';
        if(isset($_GET['mode'])) {
            if ($_GET['mode'] == 'manual') {
                echo '<form action="../../incPHP/criarplaylist.php?manual" method="post">
                          <label>Nome<input type="text" name="pname" placeholder="inserir nome da playlist"></label><br>
                          <label>Música<input type="text" name="songs" placeholder="pesquisar por título ou artista" list="songs"></label>
                          <button type="submit" name="newplaylist" class="ouvintesbtn">Criar</button>
                      </form>
                    </div>';
            }
        }
    }

    ?>

</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>