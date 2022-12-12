<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["searchlist"])) {
    $search = $_POST['search'];

    if (empty($search) !== false) {
        header("location:../ouvinte/biblioteca/all.php");
        exit();
    }
    else {
        header("Location: ../ouvinte/biblioteca/all.php?search=$search");
        exit();
    }
}