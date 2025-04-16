<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debut = $_POST['date_debut'];
    $fin = $_POST['date_fin'];
    $jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi"];
    $data = [
        "debut" => $debut,
        "fin" => $fin,
        "jours" => []
    ];

    foreach ($jours as $jour) {
        $data["jours"][$jour] = [
            "horsdoeuvre" => isset($_POST["{$jour}_horsdoeuvre"]) ? $_POST["{$jour}_horsdoeuvre"] : "",
            "plat1" => isset($_POST["{$jour}_plat1"]) ? $_POST["{$jour}_plat1"] : "",
            "plat2" => isset($_POST["{$jour}_plat2"]) ? $_POST["{$jour}_plat2"] : "",
            "accompagnement1" => isset($_POST["{$jour}_acc1"]) ? $_POST["{$jour}_acc1"] : "",
            "accompagnement2" => isset($_POST["{$jour}_acc2"]) ? $_POST["{$jour}_acc2"] : "",
            "fromage" => isset($_POST["{$jour}_fromage"]) ? $_POST["{$jour}_fromage"] : "",
            "dessert" => isset($_POST["{$jour}_dessert"]) ? $_POST["{$jour}_dessert"] : ""
        ];
    }

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $filename = "menus/menu-{$debut}_{$fin}.json";

    if (!is_dir("menus")) {
        mkdir("menus");
    }

    file_put_contents($filename, $json);

    echo "<p>Menu enregistré pour la semaine du $debut au $fin.</p>";
    echo '<a href="index.php">Retour</a>';
}
?>

