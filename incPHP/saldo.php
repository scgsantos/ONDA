<?php
session_start();
$str = "dbname=LDMovies user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["mudarSaldo"])) {
    $valor1 = $_POST['valor1'];

    if (empty($valor1) !== false) {
        header("location:../perfil.php?error=p1_emptyfields");
        exit();
    }
    else {
        $userlogged = $_SESSION['username'];
        $saldo = pg_query($conn, "SELECT saldo FROM users WHERE username = '$userlogged'");
        $row = pg_fetch_array($saldo);
        $novosaldo = $valor1 + $row['saldo'];
        pg_query($conn, "update users set saldo='$novosaldo' where username = '$userlogged'");

        header("location:../perfil.php");
        exit();
    }

} else if (isset($_POST["transfSaldo"])) {
    $destusername = $_POST['user'];
    $valor2 = $_POST['valor2'];
    $userlogged = $_SESSION['username'];
    $saldo = pg_query($conn, "SELECT saldo FROM users WHERE username = '$userlogged'");
    $row1 = pg_fetch_array($saldo);

    if ((empty($destusername) || empty($valor2)) !== false) {
        header("location:../perfil.php?error=p1_emptyfields");
        exit();
    }
    else if ($valor2 > $row1['saldo']) {
        header("location:../perfil.php?error=nobalance");
        exit();
    }
    else {
        $novosaldo = $row1['saldo'] - $valor2;
        pg_query($conn, "update users set saldo='$novosaldo' where username = '$userlogged'");

        $destsaldo = pg_query($conn, "SELECT saldo FROM users WHERE username = '$destusername'");
        $row2 = pg_fetch_array($destsaldo);
        $novodestsaldo = $row2['saldo'] + $valor2;
        pg_query($conn, "update users set saldo='$novodestsaldo' where username = '$destusername'");

        header("location:../perfil.php");
        exit();
    }
}
else {
    header("location:../perfil.php");
    exit();
}