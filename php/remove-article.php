<?php
    include ".." . DIRECTORY_SEPARATOR . "config.php";
    include "db-conn.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_GET["article"]) {
        $query = 'DELETE FROM articolo WHERE id = "' . $_GET["article"] . '";';
        $queryResult = mysqli_query($mysqli, $query);

        if ($queryResult) {
            $mysqli->close();
            header("Location:" . "." . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "admin-article-list.php" );
            exit();
        }
    }
?>