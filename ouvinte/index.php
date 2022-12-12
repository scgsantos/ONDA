<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Ouvinte</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="ouvinte">
<main class="container" id="home">
    <nav class="sidenav">
        <a href="index.php"><img src="../assets/logoONDA_fundoclaro.svg" width="150" height="" alt="logo"></a>
        <?php
        $userlogged = $_SESSION['username'];
        echo "<h3 style='text-transform: uppercase'>$userlogged's ONDA</h3>";
        ?>

        <div class="dropdown" id="bibliodrop">
            <button class="ouvintesbtn" id="bibliobtn">Biblioteca</button>
            <div class="dropdown-content" id="biblionav">
                <a href="biblioteca/all.php" class="ouvintelink">Todas as músicas</a>
                <a href="biblioteca/playlists.php" class="ouvintelink">Playlists</a>
                <a href="biblioteca/favorites.php" class="ouvintelink">Favoritas</a>
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
                <a href="../incPHP/logout.php" class="ouvintelink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="home">
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>