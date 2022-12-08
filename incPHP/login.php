<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["login"])) {

    $op = $_GET['op'];

    if ($op == 'art') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];
        $lvl = 'artista';

        if ((empty($username) || empty($pwd)) !== false) {
            header("location:../auth_artista.php?error=l_emptyfields");
            exit();
        } else {
            $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username' and password = '$pwd' and level = '$lvl'") or die;
            $row = pg_fetch_array($result);

            if ($row['username'] == $username && $row['password'] == $pwd && $row['level'] == $lvl) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $pwd;
                $_SESSION['level'] = $lvl;

                header("Location: ../home_artista.php");
                exit();
            } else {
                header("location:../auth_artista.php?error=wronglogin");
                exit();
            }
        }
    }

    else if ($op == 'ouv') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];
        $lvl = 'ouvinte';

        if ((empty($username) || empty($pwd)) !== false) {
            header("location:../auth_ouvinte.php?error=l_emptyfields");
            exit();
        } else {
            $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$pwd' AND level = '$lvl'") or die;
            $row = pg_fetch_array($result);

            if ($row['username'] == $username && $row['password'] == $pwd && $row['level'] == $lvl) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $pwd;
                $_SESSION['level'] = $lvl;

                header("Location: ../home_ouvinte.php");
                exit();
            } else {
                header("location:../auth_ouvinte.php?error=wronglogin");
                exit();
            }
        }
    }
}

else exit();