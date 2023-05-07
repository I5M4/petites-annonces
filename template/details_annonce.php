<?php
// met en forme les details d'une annonce
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="display:flex; justify-content: space-around">

        <div style="width:30% ;">

            <h1 style="text-align:center"><?= $annonce->html("titre") ?></h1>
            <img style="height: 400px; text-align:center" src="<?= $annonce->get("img") ?>">
            <p>Description : <?= $annonce->html("description") ?></p>
            <p>Prix de départ : <?= $annonce->html("prix") ?> €</p>
            <p>Depuis le : <?= $annonce->html("date") ?> </p>
            <?php $annonce->afficherMail() ?>

        </div>

        <div style="width:30%">
            <form class="form-offre">

                <?php $_SESSION["id"] != $annonce->html("createur") ? include "template/fragment/form_offre.php" : "" ?>

                <input type="hidden" name="annonce" value="<?= $_GET["annonce"] ?>">
            </form>




            <?php $_SESSION["id"] != $annonce->html("createur") ? include "template/fragment/btn_proposer_prix.php" : "" ?>
            <?php include "template/fragment/btn_voir_offre.php" ?>

            <div class="liste-offre">

            </div>
        </div>
        <a href="routeur.php">Page d'accueil</a>
    </div>

    <script src="js/fonction.js"></script>
    <script src="js/jquery.js"></script>
</body>

</html>