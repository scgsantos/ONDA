<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["registo"])) {
    $username = $_POST['user'];
    $pwd = $_POST['pwd'];
    $pwd_confirm = $_POST['pwd_confirm'];
    $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username'") or die;

        //erros no form
    //se o username já existe
    $rows = pg_num_rows($result);
    if ($rows > 0) {
        header("location:../auth_artista.php?error=usernametaken");
        exit();
    }
    //se algum campo está vazio
    else if ((empty($username) || empty($pwd) || empty($pwd_confirm)) !== false) {
        header("location:../auth_artista.php?error=r_emptyfields");
        exit();
    // se a password e a sua repetição são iguais
    } else if (($pwd !== $pwd_confirm) !== false) {
        header("location:../auth_artista.php?error=differentpwds");
        exit();
    }
    else {
        pg_query($conn, "INSERT INTO users (username, password, saldo, admin) VALUES ('$username', '$pwd', '0', '0')");
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $pwd;
        header("location: ../index.php");
        exit();
    }
}
else {
    header("location:../auth_artista.php");
    exit();
}