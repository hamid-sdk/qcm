<?php
include("header.php");
if (!isset($_SESSION["id_users"])) {
    header("location:connexion.php?Veuillez vous connectez pour voir le resultat de votre quiz");
}
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
    <div class="reponses">
        <h1>Resultat de votre quiz</h1>
        <?php
        if (isset($_POST["bouton"])) {
            // j'initialise d'abord le total à 0 comme ca a chaque bonne réponse la personne aura +2
            $noteTotal = 0;
            // je parcours les données postées pour récupérer les questions que l'utilisateur a répondues et ses réponses 
            foreach ($_POST as $idq => $idr) {
                // j'evite de prendre en compte le bouton de soumission 
                if ($idq != "bouton") {
                    // je me connecte a la base de donnée 
                    include("connect.php");
                    // je lance une requette pour recuperer d'abord la vraie réponse a chaque question choisie  et si la personne a choisie la bonnne réponse je ne vais plus afficher cette questions mais plutot les questions où il a mal répondue 
                    $requette = "select * from reponses where idq='$idq' and verite='1'";
                    // j'execute cette requette 
                    $execute = mysqli_query($id, $requette);
                    // j'affiche une ligne de cette précedente requette 
                    $ligne = mysqli_fetch_assoc($execute);

                    // // je compare l'ID de la réponse de l'utilisateur avec l'ID de la réponse correcte et non l'id de la reponse de l'utilisateur avec la verite(important)
                    if ($idr == $ligne["idr"]) {
                        $noteTotal += 2;
                    }
                    // dans le cas où la réponse n'est pas juste je l'affiche la question qu'il a raté,sa réponse  et la bonne réponse  
                    else {
                        // je lance donc une requette pour afficher toutes les questions restantes c'est a dire les questions que l'utilisateur n'a pas trouver 
                        $requette1 = "select * from questions where idq=$idq";
                        // j'exécute ma requette
                        $execute1 = mysqli_query($id, $requette1);
                        // je recupère maintenat une ligne de ce résultat pour l'afficher à l'utilisateur 
                        $ligne1 = mysqli_fetch_assoc($execute1);

                        // je lance une requette pour afficher les réponses restantes c'est a dire les réponses fausses que l'utilisateur a choisie
                        $requette2 = "select * from reponses where  idr=$idr";
                        // j'ecute egalement cette deuxieme requette 
                        $execute2 = mysqli_query($id, $requette2);
                        // je recupere la ligne de la reponse de l'utilisateur a chaque questions 
                        $ligne2 = mysqli_fetch_assoc($execute2);
                        echo "<div class='resultats-details'>";
                        echo "<h1>$ligne1[libelleQ]</h1>";
                        echo '<p class="mauvaise-reponse"> Votre reponse"'. $ligne2["libeller"] .'" est fausse </p>';
                        echo '<p class="bonne-reponse">la bonne réponse est "'.$ligne["libeller"].'"</p>';
                        echo "</div>";
                    }
                }
            }
            // j'affiche maintenant la note total de l'utilisateur 
            if($noteTotal>10){
            echo "<p class='bon' >Votre note total est $noteTotal/20</p>";
            }else{
            echo "<p class='mauvais' >Votre note total est $noteTotal/20</p>";
            }
            // je veux maintenant enregistrer les resultats de la personne connectée donc je recupere le nécessaire 
            $id_users = $_SESSION["id_users"];
            $date = date("Y-m-d H:i:s");
            $niveau = $_SESSION["niveau"];
            // je lance ma requetted'insertion
            $requette3 = "INSERT INTO historique (id_users, note, date, niveau) VALUES ('$id_users', '$noteTotal', '$date','$niveau')";
            // j'execute maintenant ma requette 
            $execute3 = mysqli_query($id, $requette3);
            
        } else {
            header("location:questionnaire.php?veuillez repondre au quiz");
        }
        //  j'affiche d'abord les questions aux quelles l'utilisateur a répondue 

        ?>

    </div>
</body>

</html>