<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["login"])) {

    $op = $_GET['op'];

    if ($op == 'art') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];

        if ((empty($username) || empty($pwd)) !== false) {
            header("location:../artista/auth.php?error=l_emptyfields");
            exit();
        } else {
            $result = pg_query($conn, "SELECT * FROM artists WHERE username = '$username' and password = '$pwd'") or die;
            $row = pg_fetch_array($result);

            if ($row['username'] == $username && $row['password'] == $pwd) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $pwd;

                header("Location: ../artista/index.php");
                exit();
            } else {
                header("location:../artista/auth.php?error=wronglogin");
                exit();
            }
        }
    }

    else if ($op == 'ouv') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];

        if ((empty($username) || empty($pwd)) !== false) {
            header("location:../ouvinte/auth.php?error=l_emptyfields");
            exit();
        } else {
            $result = pg_query($conn, "SELECT * FROM clients WHERE username = '$username' AND password = '$pwd'") or die;
            $row = pg_fetch_array($result);

            if ($row['username'] == $username && $row['password'] == $pwd) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $pwd;

                header("location: ../ouvinte/index.php");
                exit();
            } else {
                header("location: ../ouvinte/auth.php?error=wronglogin");
                exit();
            }
        }
    }
}

else exit();