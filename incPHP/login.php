<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["login"])) {
    $username = $_POST['user'];
    $pwd = $_POST['pwd'];

    if ((empty($username) || empty($pwd)) !== false) {
        header("location:../auth_artista.php?error=l_emptyfields");
        exit();
    } else {
        $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username' and password = '$pwd'") or die;
        $row = pg_fetch_array($result);

        if ($row['username'] == $username && $row['password'] == $pwd) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $pwd;
            header("Location: ../index.php");
            exit();
        } else {
            header("location:../auth_artista.php?error=wronglogin");
            exit();
        }
    }
}
else {
    header("location:../auth_artista.php");
    exit();
}