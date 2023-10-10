<?php
$str = "dbname=railway user=postgres password=A1wgDErIGszzRn96AAML host=containers-us-west-141.railway.app port=6790";
$conn = pg_connect($str) or die ("Erro na ligação");

if (isset($_POST["sortlist"])) {
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