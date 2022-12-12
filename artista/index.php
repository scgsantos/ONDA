<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Artista</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="artista">
<main class="container" id="home">
    <nav class="sidenav">
        <a href="index.php"><img src="../assets/logoONDA_fundoescuro.svg" width="150" height="" alt="logo"></a>
        <?php
        $userlogged = $_SESSION['username'];
        echo "<h3><b>$userlogged</b>'s ONDA</h3>";
        ?>

        <a href="#">
            <button class="artistasbtn">Minha Biblioteca</button>
        </a>

        <div class="dropdown" id="pessoaldrop">
            <button class="artistasbtn" id="pessoalbtn">Área Pessoal</button>
            <div class="dropdown-content" id="pessoalnav">
                <a href="#" class="artistalink">Estatísticas</a>
                <a href="#" class="artistalink">Definições</a>
                <a href="../incPHP/logout.php" class="artistalink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="home">
    </section>
</main>
<script>
    document.body.style.background = "var(--black)";
</script>
</body>
</html>