<?php
    include("../database/selectInfotherminal.php");
    ob_clean();
    if(isset($_GET['ip']) && isset($infotherminalList1)) {
        $url = $_GET['ip'];
        foreach ($infotherminalList1 as $datensatz) {
            if($url === $datensatz[1]) {
                echo $url;
                exit;
            }else{
                echo false;
                exit;
            }
        }
    }else{
        echo false;
    }
