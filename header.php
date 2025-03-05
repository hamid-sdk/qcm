<?php
session_start();
if (!isset($_SESSION["id_users"])) {
    header("location:connexion.php?=Veuillez_vous_connectez");
}
// je me connecte a la base de donnée 
include('connect.php');
// je lance une requette pour identifier l'administrateur 
$requette = "select * from users where id_users ='1'";
// j'execuet la requette 
$execute = mysqli_query($id, $requette);
// je recupere une ligne de la requette 
$ligne = mysqli_fetch_assoc($execute);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="menu">
        <ul>
            <?php
            if ($_SESSION["id_users"] !== '1') {
            ?>

                <li>
                    <a class="top-sous-menu" href="niveau.php">Niveau</a>
                    <div class="sous-menu">
                        <p style="color: white;">Votre niveau actuelle est le niveau <?= $_SESSION["niveau"] ?> <a href="niveau.php">Voulez vous changer de niveau?</a></p>
                    </div>
                </li>
            <?php
            }
            ?>
            <li><a href="historique.php">Historiques</a></li>
            <?php
            // je verifie que la personne connectée est l'administrateur 
            if ($ligne["id_users"] == $_SESSION["id_users"]) {
            ?>
                <li><a class="top-sous-menu" href="questionnaire.php">Liste des Questions</a></li>
                <li><a class="top-sous-menu" href="ajoutModif.php">Ajouter Questions</a></li>
            <?php
            }
            ?>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>
    </nav>
</body>

</html>