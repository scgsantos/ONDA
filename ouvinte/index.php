<?php
session_start();

if(!isset($_SESSION['username'])) header("location: ../index.php");
else $userlogged = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Ouvinte</title>
    <link rel="icon" href="../assets/ONDAicon.svg">
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://api.fontshare.com/v2/css?f[]=nippo@200,300,500,700,400&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=boxing@400&display=swap" rel="stylesheet">
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
            </div>
        </div>

        <div class="dropdown" id="pessoaldrop">
            <button class="ouvintesbtn" id="pessoalbtn">Área Pessoal</button>
            <div class="dropdown-content" id="pessoalnav">
                <a href="#" class="ouvintelink">Definições</a>
                <a href="../incPHP/logout.php" class="ouvintelink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="home">
        <h1>BEM-VINDO AO<br><strong style="font-size: 3rem">ONDA</strong> PARA OUVINTES!</h1>
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>