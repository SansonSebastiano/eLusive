<?php
    include ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php";
    require ".." . DIRECTORY_SEPARATOR . "check-conn.php";

    session_start();

    if ($_SESSION['ruolo'] != 'admin' && $_SESSION['ruolo'] != 'writer') {
        //echo "<script>alert('Spiacente! Non hai permessi di amministratore');</script>";
        header("Location: " . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "index.php ");
    }
    $_SESSION["prev_page"] =  $faar_ref;

    $page = file_get_contents($html_path . "form-add-article.html");

    $page = str_replace("<greet/>", "Ciao, ", $page);
    $page = str_replace("<user-img/>", $icon_user_ref, $page);
    $page = str_replace("<user/>", $_SESSION["username"], $page);
    $page = str_replace("<log-in-out/>", $log_in_out, $page);
    $page = str_replace("<script-conn/>", $user, $page);
    
    echo $page;
?>