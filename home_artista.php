<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Artista</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="artista">
<main class="container" id="home">
    <nav class="sidenav">
        <a href="home_artista.php"><img src="assets/logoONDA_fundoescuro.svg" width="150" height="" alt="logo"></a>
        <?php
        $userlogged = $_SESSION['username'];
        echo "<h3><b>$userlogged</b>'s ONDA</h3>";
        ?>
        <a href="#">
            <button class="artistasbtn">Biblioteca</button>
        </a>
        <a href="#">
            <button class="artistasbtn">Novos Lançamentos</button>
        </a>
        <a href="#">
            <button class="artistasbtn">Área Pessoal</button>
        </a>
        <a href="incPHP/logout.php">
            <button class="artistasbtn">Log out</button>
        </a>
    </nav>

    <section class="home">
    </section>
</main>
<script>
    document.body.style.background = "var(--black)";
</script>
</body>
</html>