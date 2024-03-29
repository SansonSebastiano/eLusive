<?php
    include ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php";
    include ".." . DIRECTORY_SEPARATOR . "check-conn.php";
    include ".." . DIRECTORY_SEPARATOR . "db-conn.php";
    

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SESSION['ruolo'] != 'admin') {
        $mysqli->close();
        header("Location: " . $index_ref);
        exit();
    }

    $_SESSION["prev_page"] =  $admin_page_animal_list_ref;

    $table = file_get_contents($modules_path . "admin-letter-table.html");
    $animal_entry = file_get_contents($modules_path . "admin-animal-entry.html");
    $page = file_get_contents($html_path . "admin-animal-list.html");

    $goUpPath = "../../";
    include $php_path . "template-loader.php";

    $page = str_replace("<greet/>", "Ciao, ", $page);
    $page = str_replace("<user-img/>", $icon_user_ref, $page);
    $page = str_replace("<user/>", isset($_SESSION["username"]) ? $_SESSION["username"] : "", $page);
    $page = str_replace("<log-in-out/>", $log_in_out, $page);

    $alphas = range('A', 'Z');

    $query = "SELECT nome,descrizione,status FROM animale WHERE nome REGEXP '^[^a-zA-Z]' ORDER BY nome ASC;";
    $queryResult = mysqli_query($mysqli, $query);
    $row = "";

    if (!$queryResult) {
        $mysqli->close();
        header("Location: " . $html_ref . "404.html");
        exit();
    }

    $navigator = "";
    $all_sections = "";

    foreach($alphas as $letter){
        $sql = "SELECT nome,descrizione,status FROM animale WHERE LOWER(nome) REGEXP '^" . $letter . "' ORDER BY nome ASC;";
        $queryResult = mysqli_query($mysqli, $sql);
        $animals = "";
        if($queryResult->num_rows > 0){
            $newTable = str_replace("<letter/>",$letter,$table);
            $newTable = str_replace("<letter-title/>",$letter,$newTable);
            $navigator .= '<li><a href="#'.$letter.'" tabindex="0">'.$letter.'</a></li>';
            while($row = mysqli_fetch_assoc($queryResult)){
                $newEntry = str_replace("<animal/>",$row['nome'],$animal_entry);
                $newEntry = str_replace("<desc/>",$row['descrizione'],$newEntry);
                $newEntry = str_replace("<status/>",ucfirst($row['status']),$newEntry);
                $animals .= $newEntry; 
            }
            $newTable = str_replace("<animals/>",$animals,$newTable);
            $all_sections .= $newTable;
            $queryResult->free_result();
        }
    }
    $page = str_replace("<navigator/>", $navigator,$page);
    $page = str_replace("<to-fill/>", $all_sections,$page);

    $mysqli->close();

    echo $page;
?>