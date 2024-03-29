<?php
session_start();
$str = "dbname=railway user=postgres password=A1wgDErIGszzRn96AAML host=containers-us-west-141.railway.app port=6790";
$conn = pg_connect($str) or die ("Erro na ligação");

if(!isset($_SESSION['username'])) header("location: ../index.php");
else $userlogged = $_SESSION['username'];

$songs = pg_query($conn, "SELECT * FROM songs WHERE artist = '$userlogged'") or die;
$song = pg_fetch_all($songs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONDA | Minha Biblioteca</title>
    <link rel="icon" href="../assets/ONDAicon.svg">
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://api.fontshare.com/v2/css?f[]=nippo@200,300,500,700,400&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=boxing@400&display=swap" rel="stylesheet">
</head>
<body class="artista">
<main class="container" id="biblioteca">
    <nav class="sidenav">
        <a href="index.php"><img src="../assets/logoONDA_fundoescuro.svg" width="150" height="" alt="logo"></a>
        <?php
        echo "<h3 style='text-transform: uppercase'>$userlogged's ONDA</h3>";
        ?>

        <a href="biblioteca.php">
            <button class="artistasbtn">Minha Biblioteca</button>
        </a>

        <div class="dropdown" id="pessoaldrop">
            <button class="artistasbtn" id="pessoalbtn">Área Pessoal</button>
            <div class="dropdown-content" id="pessoalnav">
                <a href="#" class="artistalink">Definições</a>
                <a href="../incPHP/logout.php" class="artistalink">Terminar sessão</a>
            </div>
        </div>
    </nav>

    <section class="biblioteca">
        <h1>Minha Biblioteca</h1>
        <h2>Todas as músicas</h2>

        <a href="../incPHP/adicionarmusica.php?new">
            <button class="artistasbtn" id="new">﹢ Adicionar nova música</button>
        </a>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th><h3>Título</h3></th>
                    <th><h3>Álbum</h3></th>
                    <th><h3>Género</h3></th>
                    <th><h3>Adicionada</h3></th>
                    <th><h3></h3></th>
                    </tr></thead>
                <tbody>
                    <?php
                    foreach ($song as $s) {

                        $album = $s['album'];
                        $albums = pg_query($conn, "SELECT * FROM albums WHERE id = $album") or die;
                        $album = pg_fetch_array($albums);

                        echo "<tr><td>" . $s['title'] . "</td>";
                        echo "<td>" . $album['title'] . "</td>";
                        echo "<td>" . $s['genre'] . "</td>";
                        echo "<td>" . $s['added'] . "</td>";
                        $s_id = $s['id'];
                        $remove_link = '../incPHP/removermusica.php?remove&id=' . $s_id;
                        $edit_link = '../incPHP/editarmusica.php?id=' . $s_id;
                        echo '<td>
                                <a href="'.$edit_link.'"><button class="artistasbtn" id="remove">editar</button></a>
                                <a href="'.$remove_link.'"><button class="artistasbtn" id="remove">remover</button></a>
                              </td></tr>';
                    }
                    ?>
                <tbody>

            </table>
        </div>
        <?php

        if (isset($_GET['new'])) {
            echo '<div class="popup-content">
            <a class="close" style="font-size: 2rem" href="./biblioteca.php">×</a>
            <h2>Adicionar nova música</h2>
        
            <form id="newsong" action="../incPHP/adicionarmusica.php" method="post"></form>

            <label>Título<input form="newsong" type="text" name="title" placeholder="insere o título da música" /></label>
            <label>Álbum<input form="newsong" name="album" type="text" placeholder="insere o título do álbum" /><br>
            <input style="margin-left: 3.9rem; margin-top: 1rem" form="newsong" name="album" value="no_album" type="checkbox" />não pertence a um álbum</label>
            <label>Género
            <select form="newsong" name="genre" id="genre">
              <option value="null">seleciona um</option>
              <option value="Rock">Rock</option>
              <option value="Blues">Blues</option>
              <option value="Classical">Classical</option>
              <option value="Country">Country</option>
              <option value="Electronic">Electronic</option>
              <option value="Folk">Folk</option>
              <option value="Hiphop">Hip-Hop</option>
              <option value="Jazz">Jazz</option>
              <option value="New Age">New Age</option>
              <option value="Pop">Pop</option>
            </select></label>
            <button form="newsong" type="submit" name="newsong" class="artistasbtn">Adicionar</button>';

            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") echo "<p class='error'>Preenche todos os campos</p>";
            }
        }

        else if (isset($_GET['edit'])) {
            $song_id = $_GET['id'];
            $action = '../incPHP/editarmusica.php?id=' . $song_id;
            echo '<div class="popup-content">
            <a class="close" style="font-size: 2rem" href="./biblioteca.php">×</a>
            <h2>Editar música</h2>
        
            <form id="editsong" action="'.$action.'" method="post"></form>

            <label>Título<input form="editsong" type="text" name="title" placeholder="inserir título da música" /></label>
            <button form="editsong" type="submit" name="editsong" class="artistasbtn">Alterar</button>';

            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") echo "<p class='error'>Preenche todos os campos</p>";
            }


        }

        else if (isset($_GET['remove'])) {
            $s_id = $_GET['id'];
            $href = '../incPHP/removermusica.php?id=' . $s_id . '&yes';
            echo '<div class="popup-content" id="confirmation">
                <h3>Tens a certeza que pretendes remover esta música?</h3>
                
                <a href="'.$href.'"><button class="artistasbtn">Sim</button></a>
                <a href="./biblioteca.php"><button class="artistasbtn">Cancelar</button></a>';
        }

            ?>
    </section>
</main>
<script>
    document.body.style.background = "var(--black)";
</script>
</body>
</html>