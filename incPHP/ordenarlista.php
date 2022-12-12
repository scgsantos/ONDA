<?php
$str = "dbname=ONDA user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["list"])) {
    $sort = $_POST['sort'];
    $order = $_POST['order'];

    if ((is_null($sort) || is_null($order)) !== false) {
        header("location:../ouvinte/biblioteca/all.php");
        exit();
    }
    else {
        header("Location: ../ouvinte/biblioteca/all.php?sort=$sort&order=$order");
        exit();
    }
}