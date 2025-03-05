    <?php
    session_start();
    if (isset($_SESSION["id_users"])) {

        if ($_SESSION["id_users"] == '1') {
            // je me connecte a la base de donnée 
            include("connect.php");
            if (isset($_GET["question"])) {
                $idq = $_GET["question"];
                // je lance une requette pour supprimer la question  
                $requette = "DELETE FROM questions  WHERE idq='$idq'";
                // j'execute ma requette 
                $execute = mysqli_query($id, $requette);
                // je lance une requette pour supprimer les reponses a cette même question 
                $requette1 = "DELETE FROM reponses WHERE idq='$idq'";
                // j'execute la requette 
                $execute1 = mysqli_query($id, $requette1);
                $_SESSION["messages"] = "Votre question et ses réponses ont bien été supprimées.";
                header("location:questionnaire.php");
            } else {
                header("location:questionnaire.php?Veuillez choisir une question");
            }
        }
    } else {
        header("location:connexion.php?=Veuillez_vous_connectez_pour_supprimer_une question");
    }
    ?>
