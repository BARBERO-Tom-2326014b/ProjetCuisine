<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Cantine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="text-align:center;">Menu de la semaine</h2>

<form action="save.php" method="POST" id="menuForm">
    <label>Semaine du :</label>
    <input type="date" name="date_debut" id="date_debut" required>

    <label>au :</label>
    <input type="date" name="date_fin" id="date_fin" required readonly>

    <div id="jours-container"></div>

    <button type="submit">Enregistrer</button>
</form>

<script src="script.js"></script>



</body>
</html>
