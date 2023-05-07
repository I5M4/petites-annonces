
document.addEventListener("DOMContentLoaded", function () {

    $(".mes-annonces").click(function () { afficheListeAnnonce("annonce") });
    $(".mes-offres").click(function () { afficheListeAnnonce("offre") });
    $(".btn-filtre").click(function (e) { e.preventDefault(); afficheListeAnnonce() });

    $(document.body).on("click", ".btn-accepter-offre", function () {
        let idOffre = $(this).data("idoffre")
        accepterOffre(idOffre)
    })
    $(document.body).on("click", ".btn-decliner-offre", function () {
        let idOffre = $(this).data("idoffre")
        refuserOffre(idOffre)
    })

    $(".btn-propose").click(enregistreOffre);
    $(".btn-affiche-offre").click(function () { afficheListeOffre($("input[name=annonce]").val()), setInterval(afficheListeOffre, 1000, $("input[name=annonce]").val()) });
    $("button.btn-accepter-offre").click(function () { accepterOffre($(this).val()) });
})


function afficheListeAnnonce($cible) {
    //Role : prepare et execute le controleur qui affiche la liste des annonces
    //parametre :
    //          : $cible , avec quoi on tri (annonce ou offre ? ou vide)
    //retour: néant 
    let target
    if ($cible == undefined) {

        target = "";
        $(".form-filtrage").show();
    } else {

        target = "&cible=" + $cible;
        $(".form-filtrage").hide();
    }
    let url = "routeur.php?action=afficher_liste_annonce&class=annonce" + target;

    let formData = $(".form-filtrage").serialize();
    $.ajax(url, {

        method: "POST",
        data: formData,
        success: finaliseAfficheAnnonce,
        error: function () { console.error("erreur de communication") },
    })
    $(".listeAnnonces").html("chargement en cours ...");

}

function finaliseAfficheAnnonce($donnee) {
    //Role :  envoie les donnee, recuperer du controleur, dans le template accueil
    //parametre : $donnee, celle envoyer depuis le controleur afficher_liste_annonce.php
    //retour : néant


    $(".listeAnnonces").empty();
    $(".listeAnnonces").html($donnee);
    $(".listeAnnonces").append($("<a href='routeur.php'>Retour</a>"));

}

function enregistreOffre() {
    //role: enregistrer une offre
    //paramètre: néant
    //retour: néant

    let url = "routeur.php?action=enregistre_offre&class=offre";

    let formdata = $(".form-offre").serialize();

    $.ajax(url, {

        method: "POST",
        data: formdata,
        success: confirmOffre,
        error: function () { console.error("erreur de communication") },
    })

}

function confirmOffre(donnee) {
    //role : confirm que l'offre a été enregistré dans la bdd avec un message
    //parametre: néant
    //retour: néant
    $(".form-offre").prepend("<p class='message'>Offre enregistré</p>");
    setTimeout(function () { $(".message").remove(); }, 2000);

}

function afficheListeOffre(annonce) {
    //role: afficher la liste des offre pour un details d'annonce
    //parametre: annonce, id de l'annonce a laquelle les offres doivent faire reference
    //retour : néant

    let url = "routeur.php?action=afficher_offre&class=offre&annonce=" + annonce;
    let formdata = $(".form-offre").serialize()
    $.ajax(url, {

        method: "POST",
        data: formdata,
        success: finaliseAfficheOffre,
        error: function () { console.error("erreur de communication") },
    })

}

function finaliseAfficheOffre(donnee) {


    $(".liste-offre").empty();
    $(".liste-offre").append(donnee);
}

function accepterOffre(idOffre) {
    //role : execute le controleur qui accepte l'offre
    //param : id de l'offre
    //retour: néant

    let url = "routeur.php?action=accepter_offre&class=offre&offre=" + idOffre;

    $.ajax(url, {

        method: "GET",
        success: function () { location.reload() },
        error: function () { console.error("erreur de communication") },
    })
}

function refuserOffre(idOffre) {
    //role: refuser l'ofre
    //idOffre : l'id de l'offre visé
    //reotur: néant
    let url = "routeur.php?action=refuser_offre&class=offre&offre=" + idOffre;
    $.ajax(url, {

        method: "GET",
        success: "",
        error: function () { console.error("erreur de communication") },
    })
}
