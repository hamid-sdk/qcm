<?php
session_start();
if (isset($_POST["boutton"])) {
    include("connect.php");
    // je recupere les informations provenant du formulaire 
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $mail=$_POST["mail"];
    $tel=$_POST["tel"];
    $mdp=$_POST["mdp"];
    // je lance une requette pour inserer les informations du formulaire dans ma base de donnée  
    $requette="insert into users (nom,prenom,mail,tel,mdp) values ('$nom','$prenom','$mail','$tel','$mdp')"; 
    // j'execute la requette 
    $execute=mysqli_query($id,$requette);
    header("location:connexion.php?Veuillez_vous_connectez");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container1 ">
        <h2>Inscription</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Entrer votre nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prenom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prenom" required>
            </div>
            <div class="form-group">
                <label for="mail">Mail</label>
                <input type="email" id="mail" name="mail" placeholder="Entrer votre mail" required>
            </div>
            <div class="form-group">
                <label for="tel">Telephone</label>
                <input type="text" id="tel" name="tel" placeholder="ex: 0123456789" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Entrer votre mot de passe " required>
            </div>
            <button type="submit" name="boutton">Se Connecter</button>
            <p><a href="connexion.php">Connectez-vous</a></p>
        </form>
    </div>
</body>

</html>