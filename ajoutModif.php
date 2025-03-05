<?php
include("header.php");
if (isset($_SESSION["id_users"])) {
    // je me connecte a la base de donnée 
    include("connect.php");
    if ($_SESSION["id_users"] !== '1') {
        header("location:questionnaire.php?Vous ne pouvez pas ajouter des questions");
    }
    if (isset($_POST["ajouter"])) {
        if (isset($_GET["question"])) {
            // je recupere les informations du formulaire pour la modification
            $question = mysqli_real_escape_string($id, $_POST["question"]);
            $niveau = mysqli_real_escape_string($id, $_POST["niveau"]);;
            // je lance maintenant une requette pour mettre a jour la question  
            $requette1 = "UPDATE questions SET libelleQ = '$question', niveau = '$niveau' WHERE idq = '$_GET[question]'";
        } elseif (isset($_GET["answer"])) {
            $reponse = mysqli_real_escape_string($id, $_POST["reponse"]);
            // je lance une requette pour modifier dans la base de donnée la réponse sélectionnée 
            $requette1 = "UPDATE reponses SET  libeller= '$reponse' WHERE idr = '$_GET[answer]'";
        } else {
            // je recupere les informations du formulaire pour l'ajout
            $question = mysqli_real_escape_string($id, $_POST["question"]);
            $niveau = mysqli_real_escape_string($id, $_POST["niveau"]);;
            $faux1 = mysqli_real_escape_string($id, $_POST["faux1"]);
            $faux2 = mysqli_real_escape_string($id, $_POST["faux2"]);
            $faux3 = mysqli_real_escape_string($id, $_POST["faux3"]);
            $vraie = mysqli_real_escape_string($id, $_POST["vraie"]);
            // je lance maintenant une requette 
            $requette1 = "INSERT INTO questions (libelleQ, niveau) VALUES ('$question','$niveau')";
        }
        // j'execute la requette 
        $execute1 = mysqli_query($id, $requette1);
        // je recupere l'id de la question ajoutée dans ma base de donnée 
        $idq = mysqli_insert_id($id);
        if (isset($_GET["question"])) {
            // Les réponses ont été insérées avec succès
            $messages = 'Question  modifiée avec succès.';
        } elseif (isset($_GET["answer"])) {
            $messages = 'Reponse  modifiée avec succès.';
        } else {
            // je lance une requette pour insérer dans la base de donnée maintenant 
            $requette2 = "INSERT INTO reponses (idq, libeller, verite) VALUES ('$idq', '$faux1', 0), ('$idq', '$faux2', 0), ('$idq', '$faux3', 0), ('$idq', '$vraie', 1)";
            // j'execute la requette 2 
            $execute2 = mysqli_query($id, $requette2);
            if ($execute2) {
                // Les réponses ont été insérées avec succès
                $messages = 'Question et réponses ajoutées avec succès.';
            } else {
                // Erreur lors de l'insertion des réponses
                echo "Erreur lors de l'insertion des réponses : " . mysqli_error($id);
            }
        }
        // je mets un messages de validation dans une session pour l'afficher dans la page questionnaire.php
        $_SESSION["messages"] = $messages;
        header("location:questionnaire.php");
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour ajouter des questions");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter ou Modifier un livre </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form class="form" action="" method="post">
        <?php
        if (isset($_GET["question"])) {
            echo "<h1>Modification</h1>";
            // je lance une requette pour recuperer la question 
            $requet = "SELECT * FROM questions WHERE idq = '$_GET[question]'";
            // j'execute la requette 
            $exec = mysqli_query($id, $requet);
            $row = mysqli_fetch_assoc($exec);
        ?>
            <input type="text" name="question" placeholder="Ajouter une question" value="<?php echo isset($_GET["question"]) ? $row["libelleQ"] : "" ?>"><br>
            <input type="number" name="niveau" placeholder="selectionner la difficulté de la question" min="0" max="1" style="width:200px ;" value="<?php echo isset($_GET["question"]) ? $row["niveau"] : "" ?>"><br>

        <?php
        } elseif (isset($_GET["answer"])) {
            echo "<h1>Modification</h1>";
            // je lance une requette pour recuperer la réponse sélectionner
            $requette = "SELECT * FROM reponses WHERE idr = '$_GET[answer]'";
            // j'execute la requette 
            $execute = mysqli_query($id, $requette);
            // je recupere la ligne 
            $ligne = mysqli_fetch_assoc($execute);
            // je recupere les lignes de la requette 
            echo '<input type="text" name="reponse"  value="' . $ligne["libeller"] . '"><br>';
        } else {
        ?>
            <h1>Ajouter une question et ses reponses</h1>
            <input type="text" name="question" placeholder="Ajouter une question"><br>
            <input type="number" name="niveau" placeholder="selectionner la difficulté de la question" min="0" max="1" style="width:100% ;"><br>
            <input type="text" name="faux1" placeholder="Ajouter une reponse fausse"><br>
            <input type="text" name="faux2" placeholder="Ajouter une reponse fausse"><br>
            <input type="text" name="faux3" placeholder="Ajouter une reponse fausse"><br>
            <input type="text" name="vraie" placeholder="Ajouter la reponse vraie"><br>
        <?php
        }
        ?>
        <input type="submit" value="Ajouter" name="ajouter">
    </form>

</body>

</html>