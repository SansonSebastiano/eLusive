<?php
    include "config.php";
    include $php_path . "db-conn.php";
    include $php_path . "check-conn.php";
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION["prev_page"] = $index_ref;

    $page = file_get_contents($html_path . "index.html");
    $goUpPath = "./";
    include $php_path . "template-loader.php";

    if (isset($_SESSION["ruolo"]) && $_SESSION["ruolo"] != "guest") {
        $page = str_replace("<greet/>", "Ciao, ", $page);
        $page = str_replace("<user-img/>", $icon_user_ref, $page);
    } else {
        $page = str_replace("<greet/>", "", $page);
        $page = str_replace("<user-img/>", "", $page);
    }
    $page = str_replace("<user/>", isset($_SESSION["username"]) ? $_SESSION["username"] : "", $page);
    $page = str_replace("<log-in-out/>", $log_in_out, $page);

    $admin_section = "<a id=\"btn-reserved\" href='" . str_replace(DIRECTORY_SEPARATOR,"/",$admin_page_ref) . "' tabindex='0'>Sezione Amministratore</a>";

    $writer_section = "<a id=\"btn-reserved\" href='" . str_replace(DIRECTORY_SEPARATOR,"/",$faar_ref) . "' tabindex='0'>Scrivi un nuovo articolo</a>";

    if (isset($_SESSION["ruolo"]) && $_SESSION["ruolo"] === "admin") {
        $page = str_replace("<admin-section/>", $admin_section, $page);
    } else {
        $page = str_replace("<admin-section/>", "", $page);
    }

    if (isset($_SESSION["ruolo"]) && $_SESSION["ruolo"] === "writer") {
        $page = str_replace("<writer-section/>", $writer_section, $page);
    } else {
        $page = str_replace("<writer-section/>", "", $page);
    }

    $carousel_item = file_get_contents($modules_path . "home-carousel-item.html");
    $query = 'SELECT id, titolo, image_path, tag, descrizione, alt FROM articolo WHERE featured=1 ORDER BY data DESC LIMIT 3;';
    $queryResult = mysqli_query($mysqli, $query);

    $items = "";
    $i = 0;
    while ($result = mysqli_fetch_assoc($queryResult)) {
        $item = $carousel_item;
        $item = str_replace("<active/>", $i === 0 ? " active" : " deactive", $item);
        $i++;

        $item = str_replace("<featured-item-img/>", $result["image_path"], $item);
        $item = str_replace("<featured-item-title/>", $result["titolo"], $item);
        $item = str_replace("<featured-item-tag/>", $result["tag"], $item);
        $item = str_replace("<featured-item-id/>", $result["id"], $item);
        $item = str_replace("<featured-item-subtitle/>", $result["descrizione"], $item);
        $item = str_replace("<featured-item-img-alt/>", $result["alt"], $item);

        $items .= $item;
    }

    $queryResult->free_result();

    $page = str_replace("<home-carousel-item/>", $items, $page);

    $homeChart = file_get_contents($modules_path . "index-chart.html");

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

    $queryResultTwo->free_result();

    $page = str_replace("<index-chart-entries/>", $entriesTwo, $page);

    $article = file_get_contents($modules_path . "index-article-list.html");

    $queryThree = 'SELECT id, titolo, image_path, tag, data, alt FROM articolo WHERE featured = 0 ORDER BY data DESC LIMIT 6;';
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

    $queryResultThree->free_result();

    $page = str_replace("<index-article-list-entries/>", $entriesThree, $page);

    $queryFour = 'SELECT data FROM articolo ORDER BY data DESC LIMIT 1;';
    $queryResultFour = mysqli_query($mysqli, $queryFour);
    if($resultFour = mysqli_fetch_assoc($queryResultFour)){
        $page = str_replace("<last-article-date/>", $resultFour["data"], $page);
    }
    $queryResultFour->free_result();

    $mysqli->close();
    echo $page;
?>