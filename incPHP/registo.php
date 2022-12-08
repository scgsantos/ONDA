<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["registo"])) {

    $op = $_GET['op'];

    if ($op == 'art') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['pwd_confirm'];

        $lvl = 'artista';

        if ((empty($username) || empty($pwd) || empty($pwd_confirm)) !== false) {
            header("location:../auth_artista.php?error=r_emptyfields");
            exit();
        }
        else {
            $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username'") or die;
            $rows = pg_num_rows($result);
            if ($rows > 0) {
                header("location:../auth_artista.php?error=usernametaken");
                exit();
            }
            else {
                if (($pwd !== $pwd_confirm) !== false) {
                    header("location:../auth_artista.php?error=differentpwds");
                    exit();
                }
                else {
                    pg_query($conn, "INSERT INTO users (username, password, level) VALUES ('$username', '$pwd', '$lvl')");
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $pwd;
                    $_SESSION['level'] = $lvl;

                    header("location: ../home_artista.php");
                    exit();
                }
            }
        }
    }

    else if ($op == 'ouv') {
        $username = $_POST['user'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['pwd_confirm'];

        $lvl = 'ouvinte';

        if ((empty($username) || empty($pwd) || empty($pwd_confirm)) !== false) {
            header("location:../auth_ouvinte.php?error=r_emptyfields");
            exit();
        }
        else {
            $result = pg_query($conn, "SELECT * FROM users WHERE username = '$username'") or die;
            $rows = pg_num_rows($result);
            if ($rows > 0) {
                header("location:../auth_ouvinte.php?error=usernametaken");
                exit();
            }
            else {
                if (($pwd !== $pwd_confirm) !== false) {
                    header("location:../auth_ouvinte.php?error=differentpwds");
                    exit();
                }
                else {
                    pg_query($conn, "INSERT INTO users (username, password, level) VALUES ('$username', '$pwd', '$lvl')");
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $pwd;
                    $_SESSION['level'] = $lvl;

                    header("location: ../home_ouvinte.php");
                    exit();
                }
            }
        }
    }
}

else exit();