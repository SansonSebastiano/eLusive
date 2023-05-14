<?php
    include ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php";
    include "conn" . DIRECTORY_SEPARATOR . "user-conn.php";

    // GESTIRE CHE UN UTENTE PUÒ ESPRIMERE UNA SOLA VOLTA IL VOTO PER OGNI ANIMALE
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $voteType = $_GET["voteType"];
    $animal = $_GET["animale"];

    if (isset($voteType) && !empty($voteType) && isset($animal) && !empty($animal)) {
        if ($voteType === "upvote") {
            // read 
            $readQuery = 'SELECT nome, YES FROM view_animale_voto WHERE nome = "'. $animal . '";';
            $readQueryResult = mysqli_query($mysqli, $readQuery);
            $result = mysqli_fetch_assoc($readQueryResult);
            $yes = $result['YES'];

            // write
            $writeQuery = "INSERT INTO `voto` (`utente`, `animale`, `voto`) VALUES ('" . $_SESSION["id"] . "', '" . $animal . "', 'YES');";
            $writeQueryResult = mysqli_query($mysqli, $writeQuery);

            // check if write is ok
            if ($writeQueryResult) {
                print_r($yes + 1);
            } else {
                print_r($yes);
            }
        } else { // $voteType === "downvote"
            // read
            $readQuery = 'SELECT nome, NO FROM view_animale_voto WHERE nome = "'. $animal . '";';
            $readQueryResult = mysqli_query($mysqli, $readQuery);
            $result = mysqli_fetch_assoc($readQueryResult);
            $no = $result['NO'];

            // write
            $writeQuery = "INSERT INTO `voto` (`utente`, `animale`, `voto`) VALUES ('" . $_SESSION["id"] . "', '" . $animal . "', 'NO');";
            $writeQueryResult = mysqli_query($mysqli, $writeQuery);

            // check if write is ok
            if ($writeQueryResult) {
                print_r($no + 1);
            } else {
                print_r($no);
            }
        }
    }
?>