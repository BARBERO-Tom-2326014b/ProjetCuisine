<?php
$debut = isset($_GET['debut']) ? $_GET['debut'] : '';
$fin = isset($_GET['fin']) ? $_GET['fin'] : '';
$filename = "menus/menu-{$debut}_{$fin}.json";

if (file_exists($filename)) {
    header('Content-Type: application/json');
    echo file_get_contents($filename);
} else {
    echo json_encode(null);
}
