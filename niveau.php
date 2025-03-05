<?php
session_start();
if (!isset($_SESSION["id_users"])) {
    header("location:connexion.php?=Veuillez_vous_connectez_pour_passer_le_quiz");
}
if (isset($_POST["ajuster"])) {
    // je vérifie si le niveau a été sélectionné
    if (isset($_POST["niveau"])) {
        // je récupére le niveau sélectionné par l'utilisateur
        $niveau = $_POST["niveau"];
        // Maintenant, j'utilise la variable $niveau pour effectuer des actions en fonction du niveau choisi
        if ($niveau == "facile") {
            // je mets le niveau dans une session pour pouvoie le prendre comme une condition dans le questionnaire 
            $_SESSION["niveaufacile"] = $niveau;
            $_SESSION["niveau"] = $niveau;
        } elseif ($niveau == "difficile") {
            // je mets le niveau dans une session pour pouvoie le prendre comme une condition dans le questionnaire 
            $_SESSION["niveaudifficile"] = $niveau;
            $_SESSION["niveau"] = $niveau;
        }
    }
    header("location:questionnaire.php");
}   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container2">
        <div>
            <p>Bonjour <b style="color: green;"><?=$_SESSION["prenom"] ?></b> Veuillez choisir un niveau</p>
            <form action="" method="post">
                <label for="facile">Facile</label>
                <input type="radio" id="facile" value="facile" name="niveau" required>
                <label for="difficile">Difficile</label>
                <input type="radio" value="difficile" name="niveau" required>
                <input type="submit" id="difficile" value="Ajuster" name="ajuster">
            </form>

        </div>
    </div>
</body>

</html>