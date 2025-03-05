<?php
require_once("header.php");
// je me connecte a la base de donnée
include "connect.php";
if (isset($_SESSION["id_users"])) {
    $id_users = $_SESSION["id_users"];
    // mon but est d'afficher l'historique de toutes les commandes de l'utilisateur 
    if ($id_users == '1') {
        $requette = "SELECT historique.*,users.* FROM historique INNER JOIN users ON historique.id_users = users.id_users";
    } else {
        $requette = "SELECT historique.*,users.* FROM historique INNER JOIN users ON historique.id_users = users.id_users WHERE historique.id_users = '$id_users'";
    }
    // j'execute ma requette 
    $execute = mysqli_query($id, $requette);
    // je verifie si il y'a des erreurs dans la requête
    if (!$execute) {
        die("Erreur dans la requête : " . mysqli_error($id));
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour accéder au panier");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Historique</title>
</head>

<body>
    <main class="history-container">
        <?php
        // je veux regarder si la personne a au moins un trucs dans son panier sinon on lui met un autre message 
        if (mysqli_num_rows($execute) > 0) {
        ?>
            <div style="text-align: center; width: 50%;margin: auto;" class="history-item"><br><br>

                <p><span>Historique(s)</span></p>
                <div>
                    <?php
                    while ($ligne = mysqli_fetch_assoc($execute)) {
                    ?>
                        <div style="background-color: MediumAquaMarine;">
                            <p>Nom:<?= $ligne["nom"] ?></p>
                            <p>Prenom :<?= $ligne["prenom"] ?></p>
                            <p>Note: <?= $ligne["note"] ?></p>
                            <p>date:<?= $ligne["date"] ?></p>
                            <p>Niveau: <?= $ligne["niveau"] ?></p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
        } else {
            ?>
                <div style="text-align: center;"><br><br>
                    <p><span>Votre Historique est vide </span></p>
                </div>
            <?php
        }
            ?>
    </main>
</body>

</html>