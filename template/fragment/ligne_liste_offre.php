<tr>
    <td><?= $offre->html("montant") ?> €</td> <?= ($offre->get('etat') == 1) ? "<td><button class='btn-accepter-offre' data-idoffre='" . $offre->id() . "' >Accepter</button></td><td><button class='btn-decliner-offre'  data-idoffre='" . $offre->id() . "'>Décliner</button></td>" : "<td>" . $offre->html("etat") . "</td> " ?>