<a href="routeur.php?action=afficher_details_annonce&class=annonce&annonce=<?= $annonce->id() ?>" style="width:14%; display:inline-block ; color:black; text-decoration:none;">
   <div style="text-align:center; border: 1px solid;  border-radius:15px; box-shadow: 1px 1px 1px 1px lightgrey">
      <p><b> <?= $annonce->html("titre") ?></b></p>
      <div style="width:200px; height:200px;"> <img style="width:100%" src="<?= $annonce->html("img") ?>" alt="<?= $annonce->html("titre") ?>"> </div>
      <p style="width:90%; overflow:hidden; height:50px;"><?= $annonce->html("description") ?></p>
      <p><?= $annonce->html("prix") ?> €</p>
      <p><?= isset($_GET["cible"]) == "annonce" ? "etat de l'annonce : " . $annonce->html("statut") : "" ?></p>
   </div>
</a>