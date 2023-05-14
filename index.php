<?php
    require "config.php";
    require $php_path . "check-conn.php";
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION["prev_page"] = $index_ref;

    $page = file_get_contents($html_path . "index.html");

    $page = str_replace("<greet/>", "Ciao, ", $page);
    $page = str_replace("<user-img/>", $icon_user_ref, $page);
    $page = str_replace("<user/>", $_SESSION["username"], $page);
    $page = str_replace("<log-in-out/>", $log_in_out, $page);
    $page = str_replace("<script-conn/>", $logUserConn, $page);

    // LOGIN SECTION
    $admin_section = "<button class=\"btn-primary\" onclick=\"location.href='" . $admin_page_ref . "'\" tabindex='2'>Sezione Amministratore</button>";

    $writer_section = "<button class=\"btn-primary\" onclick=\"location.href='" . $faar_ref . "'\" tabindex='2'>Scrivi un nuovo articolo</button>";

    if ($_SESSION["ruolo"] == "admin") {
        $page = str_replace("<admin-section/>", $admin_section, $page);
    } else {
        $page = str_replace("<admin-section/>", "", $page);
    }

    if ($_SESSION["ruolo"] == "writer") {
        $page = str_replace("<writer-section/>", $writer_section, $page);
    } else {
        $page = str_replace("<writer-section/>", "", $page);
    }

    // MAIN ARTICLES SECTION
    $query = 'SELECT id, titolo, image_path, alt, tag, descrizione FROM articolo WHERE featured=1 ORDER BY data DESC LIMIT 5;';
    $queryResult = mysqli_query($mysqli, $query);

    while ($result = mysqli_fetch_assoc($queryResult)) {
        $page = str_replace("<main-article-img/>", $result["image_path"], $page);
        $page = str_replace("<main-img-alt/>", $result["alt"], $page);
        $page = str_replace("<main-article-title/>", $result["titolo"], $page);
        $page = str_replace("<main-article-tag/>", $result["tag"], $page);
        $page = str_replace("<main-article-id/>", $result["id"], $page);
        $page = str_replace("<main-article-subtitle/>", $result["descrizione"], $page);
    }

    // ASIDE CHART SECTION
    $homeChart = file_get_contents($modules_path . "home-chart.html");

    $queryTwo = 'SELECT nome, image_path, alt FROM view_animale_voto ORDER BY YES DESC LIMIT 5;';
    $queryResultTwo = mysqli_query($mysqli, $queryTwo);

    $entriesTwo = "";

    while ($resultTwo = mysqli_fetch_assoc($queryResultTwo)) {

        $entryTwo = $homeChart;
        $entryTwo = str_replace("<chart-img/>", $resultTwo["image_path"], $entryTwo);
        $entryTwo = str_replace("<chart-img-alt/>", $resultTwo["alt"], $entryTwo);
        $entryTwo = str_replace("<animal-name/>", $resultTwo["nome"], $entryTwo);

        $entriesTwo .= $entryTwo;
    }

    $queryResultTwo->free();

    $page = str_replace("<home-chart-entries/>", $entriesTwo, $page);

    // ARTICLES LIST SECTION
    $article = file_get_contents($modules_path . "home-article-list.html");

    $queryThree = 'SELECT id, titolo, image_path, alt, tag, data FROM articolo ORDER BY data DESC LIMIT 6;';
    $queryResultThree = mysqli_query($mysqli, $queryThree);

    $entriesThree = "";
    while ($resultThree = mysqli_fetch_assoc($queryResultThree)) {

        $entryThree = $article;
        $entryThree = str_replace("<article-img/>", $resultThree["image_path"], $entryThree);
        $entryThree = str_replace("<article-img-alt/>", $resultThree["alt"], $entryThree);
        $entryThree = str_replace("<article-title/>", $resultThree["titolo"], $entryThree);
        $entryThree = str_replace("<article-tag/>", $resultThree["tag"], $entryThree);
        $entryThree = str_replace("<article-id/>", $resultThree["id"], $entryThree);

        $entriesThree .= $entryThree;
    }

    $queryResultThree->free();

    $page = str_replace("<home-article-list-entries/>", $entriesThree, $page);

    // LAST UPDATE SECTION
    $queryFour = 'SELECT data FROM articolo ORDER BY data DESC LIMIT 1;';
    $queryResultFour = mysqli_query($mysqli, $queryFour);

    $resultFour = mysqli_fetch_assoc($queryResultFour);

    $page = str_replace("<last-article-date/>", $resultFour["data"], $page);

    $queryResultFour->free();

    echo $page;
?>
