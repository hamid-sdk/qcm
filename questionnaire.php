<?php
include("header.php");
if (!isset($_SESSION["id_users"])) {
    header("location:connexion.php?=Veuillez_vous_connectez_pour_passer_le_quiz");
}
include("connect.php");
// si la personne connectée n'est pas l'administrateur 
if ($_SESSION["id_users"] !== '1') {
    // je lance une requette selon le niveau de difficulté choisi ultérieurement 
    if (isset($_SESSION["niveaufacile"])) {
        $requette = "SELECT * FROM questions where niveau=0 ORDER BY RAND() LIMIT 10";
        unset($_SESSION["niveaufacile"]);
    } elseif (isset($_SESSION["niveaudifficile"])) {
        $requette = "SELECT * FROM questions where niveau=1 ORDER BY RAND() LIMIT 10";
        unset($_SESSION["niveaudifficile"]);
    } else {
        header("location:niveau.php?Veuillez choisir un niveau de difficulté");
    }
} else {
    $requette = "SELECT * FROM questions";
}
// j'execute ma requette 
$execute = mysqli_query($id, $requette);
// Quand je clique sur le bouton 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>questionnaire</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>QCM</h1>
    <?php
    if(isset($_SESSION["messages"])){
    ?>
    <h2><?=$_SESSION["messages"]?></h2>
    <?php
    unset($_SESSION["messages"]);
    }
    ?>

    <div class="contenant">
        <form action="resultat.php" method="post">
            <?php
            $i = 1;
            while ($ligne = mysqli_fetch_assoc($execute)) {
                $libelleQ = $ligne["libelleQ"];
                $idq = $ligne["idq"];
            ?>
                <h2><b><?= $i . ":" . $libelleQ ?></b> <?php if ($_SESSION["id_users"] == '1') {
                                                    echo "<a href='AjoutModif.php?question=$idq'>✍️</a>";
                                                } ?> <?php if ($_SESSION["id_users"] == '1') {
                                                    echo "<a href='delete.php?question=$idq'>✖️</a>";
                                                } ?></h2>

                <?php
                $i += 1;
                // je lance une requette pour afficher les reponses 
                $requette = "select * from reponses where idq='$idq'";
                // j'execute la requette 
                $execute2 = mysqli_query($id, $requette);
                while ($ligne2 = mysqli_fetch_assoc($execute2)) {
                    $libeller = $ligne2["libeller"];
                    $idr = $ligne2["idr"];
                ?>
                    <label for="<?= $libeller ?>">
                        <?php
                        if ($_SESSION["id_users"] !== '1') {
                        ?>
                            <input type="radio" id="<?= $libeller ?>" name="<?= $idq ?>" value="<?= $idr ?>" required><?= $libeller ?>
                        <?php
                        } else {
                        ?>
                            <p><b><?= $libeller ?></b>    <a href="AjoutModif.php?answer=<?= $idr ?> question=<?=$idq?>">✍️</a></p>
                        <?php
                        }
                        ?>
                    </label>
                <?php
                }
            }
            if ($_SESSION["id_users"] !== '1') {
                ?>
                <button type="submit" name="bouton">Soumettre</button>
            <?php
            }
            ?>
        </form>
    </div>
</body>

</html>