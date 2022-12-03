<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Login/Registo</title>
    <link rel="icon" href="assets/ONDAicon.svg">
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://api.fontshare.com/v2/css?f[]=nippo@200,300,500,700,400&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=boxing@400&display=swap" rel="stylesheet">
</head>
<body>

<main class="container" id="auth">
    <div class="form">
        <h1>LOGIN</h1>
        <form action="incPHP/login.php" method="post">
            <input title="username" placeholder="username" type="text" name="user" autocomplete="off"><br>
            <input title="password" placeholder="password" type="password" name="pwd"><br>
            <button type="submit" name="login">></button>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "l_emptyfields") echo "<p class='error'>Preencha todos os campos</p>";
            else if ($_GET["error"] == "wronglogin") echo "<p class='error'>Username e/ou password errados</p>";
        }
        ?>
    </div>
    <div class="form">
        <h1>REGISTO</h1>
        <form action="incPHP/registo.php" method="post">
            <input title="username" placeholder="username" type="text" name="user" autocomplete="off"><br>
            <input title="password" placeholder="password" type="password" name="pwd"><br>
            <input title="password" placeholder="confirmar password" type="password" name="pwd_confirm"><br>
            <button type="submit" name="registo">></button>
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
    document.body.style.background = "var(--black)";
</script>

</body>
</html>