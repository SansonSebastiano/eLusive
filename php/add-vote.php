<?php
    include ".." . DIRECTORY_SEPARATOR . "config.php";
    include "db-conn.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $voteType = $_GET["voteType"];
    $animal = $_GET["animale"];

    if (isset($voteType) && !empty($voteType) && isset($animal) && !empty($animal)) {
        if ($voteType === "upvote") {
            
            $readQuery = 'SELECT nome, YES FROM view_animale_voto WHERE nome = "'. $animal . '";';
            $readQueryResult = mysqli_query($mysqli, $readQuery);
            $result = mysqli_fetch_assoc($readQueryResult);
            $yes = $result['YES'];

            
            $writeQuery = "INSERT INTO `voto` (`utente`, `animale`, `voto`) VALUES ('" . $_SESSION["id"] . "', '" . $animal . "', 'YES');";
            $writeQueryResult = mysqli_query($mysqli, $writeQuery);

            
            if ($writeQueryResult) {
                print_r($yes + 1);
            } else {
                if (is_null($yes)) {
                    print_r(0);
                } else {
                    print_r($yes);
                }
            }
        } else { 
            
            $readQuery = 'SELECT nome, NO FROM view_animale_voto WHERE nome = "'. $animal . '";';
            $readQueryResult = mysqli_query($mysqli, $readQuery);
            $result = mysqli_fetch_assoc($readQueryResult);
            $no = $result['NO'];

            
            $writeQuery = "INSERT INTO `voto` (`utente`, `animale`, `voto`) VALUES ('" . $_SESSION["id"] . "', '" . $animal . "', 'NO');";
            $writeQueryResult = mysqli_query($mysqli, $writeQuery);

            
            if ($writeQueryResult) {
                print_r($no + 1);
            } else {
                if (is_null($no)) {
                    print_r(0);
                } else {
                    print_r($no);
                }
            }
        }
    }

    $mysqli->close();
?>