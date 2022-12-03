<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LDMovies</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<header>
    <nav>
        <a class="active" href="index.php"><img src="img/logo.svg" width="" height="" alt="logo"></a>
        <a href="filmes.php">FILMES</a>
        <?php
        if(isset($_SESSION['username'])) {
            $userlogged = $_SESSION['username'];
            echo "<a id='perfil_button' href='perfil.php'>ÁREA PESSOAL de $userlogged</a>";
            echo "<a id='logout_button' href='incPHP/logout.php'>LOG OUT</a>";
        } else echo "<a id='perfil_button' href='auth_artista.php'>LOGIN/REGISTO</a>";
        ?>
    </nav>
</header>

<section id="home">
    <?php
    if(isset($_SESSION['username'])) {
        echo "<h1>BEM-VINDO/A $userlogged</h1></a>";
        echo "<h2>Navega pelo site e descobre as novidades que temos para te oferecer!</h2>";
    } else echo "<h2>Entra na tua conta e descobre as novidades que temos para te oferecer!</h2>";
    ?>
</section>
</body>
</html>