<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage du Menu</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(240, 248, 255, 0.85), rgba(255, 255, 255, 0.9)),
            url('https://images.unsplash.com/photo-1604908177097-27ec2b199b94?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .navbar {
            position: relative;
            width: 100%;
            height: 220px;
            background: url('img/ambulatoire.png') center/cover no-repeat;
            background-size: 100%;
        }

        .navbar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            filter: blur(8px);
            z-index: -1;
        }

        .navbar-overlay {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            padding: 15px;
            background: rgba(0, 51, 102, 0.7);
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .menu-selector {
            text-align: center;
            padding: 30px 20px 10px;
        }

        .menu-selector h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .menu-selector button {
            padding: 12px 20px;
            margin: 5px;
            border: none;
            border-radius: 25px;
            background-color: #0077b6;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .menu-selector button:hover {
            background-color: #023e8a;
            transform: scale(1.05);
        }

        .menu-semaine {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.97);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .menu-semaine h2 {
            text-align: center;
            color: #1b263b;
        }

        .jours-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .card-jour {
            background: #e9f1f7;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 20px;
            width: 500px;
            transition: transform 0.2s ease;
        }

        .card-jour:hover {
            transform: translateY(-5px);
            background-color: #d7e9f7;
        }

        .card-jour h3 {
            color: #003049;
            margin-bottom: 10px;
        }

        .plat {
            margin: 6px 0;
            padding-left: 5px;
            color: #333;
            font-size: 15px;
        }

        .active {
            display: block !important;
        }

        .ligne-menu {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            background-color: #f4f6f9;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            flex-wrap: wrap;
        }

        .ligne-menu div {
            flex: 1;
            min-width: 120px;
            background-color: #ffffff;
            border-radius: 6px;
            padding: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="navbar-overlay">
        Centre Hospitalier Montperrin – Menus de la semaine
    </div>
</div>

<div class="menu-selector">
    <h2>Sélectionnez une semaine :</h2>
</div>

<?php
$dossier = "menus/";
$fichiers = glob($dossier . "*.json");

echo "<div class='menu-selector'>";
foreach ($fichiers as $index => $fichier) {
    $contenu = file_get_contents($fichier);
    $menu = json_decode($contenu, true);
    echo "<button onclick='afficherMenu($index)'>Semaine du {$menu['debut']} au {$menu['fin']}</button>";
}
echo "</div>";

foreach ($fichiers as $index => $fichier) {
    $contenu = file_get_contents($fichier);
    $menu = json_decode($contenu, true);

    echo "<div class='menu-semaine' id='menu-$index'>";
    echo "<h2>Menu du {$menu['debut']} au {$menu['fin']}</h2>";

    echo "<div class='jours-container'>";

    foreach ($menu['jours'] as $jour => $plats) {
        echo "<div class='card-jour'>";
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
            echo "<div class='ligne-menu'>";
            echo "<div><strong>Hors d'œuvre :</strong><br>{$plats['horsdoeuvre']}</div>";
            echo "</div>";

            echo "<div class='ligne-menu'>";
            echo "<div><strong>Plat 1 :</strong><br>{$plats['plat1']}</div>";
            echo "<div><strong>Plat 2 :</strong><br>{$plats['plat2']}</div>";
            echo "</div>";

            echo "<div class='ligne-menu'>";
            echo "<div><strong>Accompagnement 1 :</strong><br>{$plats['accompagnement1']}</div>";
            echo "<div><strong>Accompagnement 2 :</strong><br>{$plats['accompagnement2']}</div>";
            echo "</div>";

            echo "<div class='ligne-menu'>";
            echo "<div><strong>Fromage :</strong><br>{$plats['fromage']}</div>";
            echo "<div><strong>Dessert :</strong><br>{$plats['dessert']}</div>";
            echo "</div>";
        }

        echo "</div>";
    }

    echo "</div>";
    echo "</div>";
}
?>

<script>
    function afficherMenu(index) {
        document.querySelectorAll('.menu-semaine').forEach(menu => {
            menu.classList.remove('active');
        });
        document.getElementById('menu-' + index).classList.add('active');
    }

    window.onload = function() {
        if (document.querySelector('.menu-semaine')) {
            afficherMenu(0);
        }
    };
</script>

</body>
</html>
