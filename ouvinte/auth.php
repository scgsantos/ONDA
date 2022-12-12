<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Login/Registo</title>
    <link rel="icon" href="../assets/ONDAicon.svg">
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://api.fontshare.com/v2/css?f[]=nippo@200,300,500,700,400&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=boxing@400&display=swap" rel="stylesheet">
</head>
<body class="ouvinte">

<main class="container" id="auth">
    <div class="logo"><img src="../assets/logoONDA_fundoclaro.svg" width="250" height="" alt="logo_fundoescuro"></div>
    <div class="form">
        <h2>Login</h2>
        <form action="../incPHP/login.php?op=ouv" method="post" autocomplete="off">
            <input title="username" placeholder="username" type="text" name="user"><br>
            <input title="password" placeholder="password" type="password" name="pwd"><br>
            <button type="submit" name="login" class="ouvintesbtn">ENTRAR</button>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "l_emptyfields") echo "<p class='error'>Preencha todos os campos</p>";
            else if ($_GET["error"] == "wronglogin") echo "<p class='error'>Username e/ou password errados</p>";
        }
        ?>
    </div>
    <div class="form">
        <h2>Registo</h2>
        <form action="../incPHP/registo.php?op=ouv" method="post" autocomplete="off">
            <input title="username" placeholder="username" type="text" name="user"><br>
            <input title="name" placeholder="nome e sobrenome" type="text" name="name"><br>
            <input title="password" placeholder="password" type="password" name="pwd"><br>
            <input title="password_confirm" placeholder="confirmar password" type="password" name="pwd_confirm"><br>
            <button type="submit" name="registo" class="ouvintesbtn">REGISTAR</button>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "r_emptyfields") echo "<p class='error'>Preencha todos os campos</p>";
            else if ($_GET["error"] == "differentpwds") echo "<p class='error'>Passwords não correspondem</p>";
            else if ($_GET["error"] == "usernametaken") echo "<p class='error'>Username indisponível</p>";
        }
        ?>
    </div>

</main>

<script>
    document.body.style.background = "var(--beige)";
</script>

</body>
</html>