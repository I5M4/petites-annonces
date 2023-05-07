
<a href="routeur.php?action=afficher_details_annonce&class=annonce&annonce=<?=$objOffre->get("annonce")->id() ?>" style="width:14%; display:inline-block ; color:black; text-decoration:none;">
<div style="text-align:center; border: 1px solid;  border-radius:15px; box-shadow: 1px 1px 1px 1px lightgrey">
   <p><b> <?= $objOffre->get("annonce")->html("titre") ?></b></p> <div style="width:200px; height:200px;"> <img style="width:100%" src="<?= $objOffre->get("annonce")->html("img") ?>" alt="<?= $objOffre->get("annonce")->html("titre") ?>"> </div><p style="width:90%; overflow:hidden; height:50px;"><p> Prix demandé :<?= $objOffre->get("annonce")->html("prix") ?> €</p><p>Mon offre : <?=$objOffre->get("montant") ?> €</p><p>Etat de l'offre : <?=$objOffre->html("etat") ?></p>
</div>
</a>