<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage du Menu</title>
    <style>
        .menu-semaine { margin: 20px; padding: 15px; border: 1px solid #ddd; }
        .jour { margin: 10px 0; }
        .plat { margin: 5px 0; }
    </style>
</head>
<body>



<?php
$dossier = "menus/";
$fichiers = glob($dossier . "*.json");

foreach ($fichiers as $fichier) {
    $contenu = file_get_contents($fichier);
    $menu = json_decode($contenu, true);

    echo "<div class='menu-semaine'>";
    echo "<h2>Menu du {$menu['debut']} au {$menu['fin']}</h2>";

    foreach ($menu['jours'] as $jour => $plats) {
        echo "<div class='jour'>";
        echo "<h3>" . ucfirst($jour) . "</h3>";

        $menuVide = empty($plats['horsdoeuvre']) &&
                   empty($plats['plat1']) &&
                   empty($plats['plat2']) &&
                   empty($plats['accompagnement1']) &&
                   empty($plats['accompagnement2']) &&
                   empty($plats['fromage']) &&
                   empty($plats['dessert']);


        if ($menuVide) {
            echo "<div class='plat'>Pas encore de menu</div>";
        } else {
            echo "<div class='plat'>Hors d'oeuvre: {$plats['horsdoeuvre']}</div>";
            echo "<div class='plat'>Plat 1: {$plats['plat1']}</div>";
            echo "<div class='plat'>Plat 2: {$plats['plat2']}</div>";
            echo "<div class='plat'>Accompagnement 1: {$plats['accompagnement1']}</div>";
            echo "<div class='plat'>Accompagnement 2: {$plats['accompagnement2']}</div>";
            echo "<div class='plat'>Fromage: {$plats['fromage']}</div>";
            echo "<div class='plat'>Dessert: {$plats['dessert']}</div>";
        }
        echo "</div>";
    }
    echo "</div>";
}
?>
</body>
</html>