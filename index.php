<?php
session_start();
require_once ('controller/indexController.php');

if (isset($_GET['action']) and $_GET['action'] != '') {
    switch ($_GET['action']) {
        case 'test';
            test();
            break;
        case 'classements';
            classements();
            break;
        case 'table';
            table();
            break;
        default:
            dashboard();
            break;
    }
} else {
    dashboard();
}

?>
