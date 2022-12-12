<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["registo"])) {

    $op = $_GET['op'];

    if ($op == 'art') {
        $username = $_POST['user'];
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['pwd_confirm'];

        if ((empty($username) || empty($pwd) || empty($pwd_confirm) || empty($name)) !== false) {
            header("location:../artista/auth.php?error=r_emptyfields");
            exit();
        }
        else {
            $result = pg_query($conn, "SELECT * FROM artists WHERE username = '$username'") or die;
            $rows = pg_num_rows($result);
            if ($rows > 0) {
                header("location:../artista/auth.php?error=usernametaken");
                exit();
            }
            else {
                if (($pwd !== $pwd_confirm) !== false) {
                    header("location:../artista/auth.php?error=differentpwds");
                    exit();
                }
                else {
                    pg_query($conn, "INSERT INTO artists (username, password, name) VALUES ('$username', '$pwd', '$name')");
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $pwd;
                    $_SESSION['name'] = $name;

                    header("location: ../artista/index.php");
                    exit();
                }
            }
        }
    }

    else if ($op == 'ouv') {
        $username = $_POST['user'];
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['pwd_confirm'];

        if ((empty($username) || empty($pwd) || empty($pwd_confirm) || empty($name)) !== false) {
            header("location: ../ouvinte/auth.php?error=r_emptyfields");
            exit();
        }
        else {
            $result = pg_query($conn, "SELECT * FROM clients WHERE username = '$username'") or die;
            $rows = pg_num_rows($result);
            if ($rows > 0) {
                header("location: ../ouvinte/auth.php?error=usernametaken");
                exit();
            }
            else {
                if (($pwd !== $pwd_confirm) !== false) {
                    header("location: ../ouvinte/auth.php?error=differentpwds");
                    exit();
                }
                else {
                    pg_query($conn, "INSERT INTO clients (username, password, name) VALUES ('$username', '$pwd', '$name')");
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $pwd;
                    $_SESSION['name'] = $name;

                    header("location: ../ouvinte/index.php");
                    exit();
                }
            }
        }
    }
}

else exit();