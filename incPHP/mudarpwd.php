<?php
session_start();
$str = "dbname=LDMovies user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["mudarPwd"])) {
    $novapwd = $_POST['pwd'];
    $pwd_confirm = $_POST['pwd_confirm'];
    $userlogged = $_SESSION['username'];

    $result = pg_query($conn, "SELECT * FROM users WHERE username = '$userlogged'") or die;

    //erros no form
    //se algum campo está vazio
    if ((empty($novapwd) || empty($pwd_confirm)) !== false) {
        header("location:../perfil.php?error=p2_emptyfields");
        exit();
        // se a password e a sua repetição são iguais
    } else if (($novapwd !== $pwd_confirm) !== false) {
        header("location:../perfil.php?error=differentpwds");
        exit();
    }
    else {
        pg_query($conn, "update users set password='$novapwd' where username = '$userlogged'");
        $_SESSION['password'] = $novapwd;
        header("location: ../perfil.php");
        exit();
    }
}
else {
    header("location:../perfil.php");
    exit();
}