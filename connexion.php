<?php
// j'ouvre une session pour circuler l'id d'une page a l'autre 
session_start();
if (isset($_POST["boutton"])) {
    include("connect.php");
    // je recupere les données provenant du formulaire 
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    // je lance une requette pour inserer les informations du formulaire dans ma base de donnée  
    $requette = "SELECT * FROM users WHERE mail='$mail' and mdp='$mdp' ";
    // j'execute ma requette 
    $execute = mysqli_query($id, $requette);
    // je verifie si la personne est dans la base de donnée
    if (mysqli_num_rows($execute) > 0) {

        // j'affiche une ligne de la requette 
        $ligne = mysqli_fetch_assoc($execute);

        // je mets l'id et le prenom  de celui qui est connecter dans une session 
        $_SESSION["id_users"] = $ligne["id_users"];
        $_SESSION["prenom"] = $ligne["prenom"];
        // je verifie que c'est l'administrateur 
        if ($_SESSION["id_users"]=='1') {
            header("location:questionnaire.php");
        } else {
            header("location:niveau.php?identifiant=$_SESSION[id_users]");
        }
    } else {
        header("location:connexion.php?=Veuillez_verifiez_vos_informations");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container ">
        <h2>Connexion</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="mail">Mail</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>
            <button type="submit" name="boutton">Se Connecter</button>
            <p>Vous n'avez pas un compte? <a href="inscription.php">Inscrivez-vous</a></p>
        </form>
    </div>
</body>

</html>