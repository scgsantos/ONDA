<?php
session_start();
$str = "dbname=LDMovies user=postgres password=postgres host=localhost port=5432";
$conn = pg_connect($str) or die ("Erro na ligação");

