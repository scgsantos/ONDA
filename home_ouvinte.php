<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Ouvinte</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="ouvinte">
<main class="container" id="home">
    <nav class="sidenav">
        <a href="home_ouvinte.php"><img src="assets/logoONDA_fundoclaro.svg" width="150" height="" alt="logo"></a>
        <?php
        $userlogged = $_SESSION['username'];
        echo "<h3><b>$userlogged</b>'s ONDA</h3>";
        ?>
        <a href="#">
            <button class="ouvintesbtn">Biblioteca</button>
        </a>
        <a href="#">
            <button class="ouvintesbtn">Novos Lançamentos</button>
        </a>
        <a href="#">
            <button class="ouvintesbtn">Área Pessoal</button>
        </a>
        <a href="incPHP/logout.php">
            <button class="ouvintesbtn">Log out</button>
        </a>
    </nav>

    <section class="home">
    </section>
</main>
<script>
    document.body.style.background = "var(--beige)";
</script>
</body>
</html>