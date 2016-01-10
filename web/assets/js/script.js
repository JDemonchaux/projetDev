$(document).ready(function () {
    $('.dropdown-button').dropdown();
    $('.collapsible').collapsible({
        accordion: true
    });
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 3,
        labelMonthNext: 'Mois prochain',
        labelMonthPrev: 'Mois précédant',
        labelMonthSelect: 'Choisir un mois',
        labelYearSelect: 'choisir une année',
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Veb', 'Sam'],
        weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        today: 'Maintenant',
        clear: 'Vider',
        close: 'Fermer',
        format: 'dd/mm/yy'
    });
    $('.tooltipped').tooltip({delay: 50});
    $('.choixApprenti').dataTable({
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });


    /**
     * Style du menu
     */
    $(".categorie-title").first().addClass("border-top");

    /**
     * Affichage du livret en consultation
     */
    $(".livret_section, .categories").hide();
    $("#formQuinzaine").hide();
    $('.periodes-livret').hide();

    $(".sections").on('click', function () {
        $(".categories").hide();
        var tmp = $(this).data("vue").split(" ");
        var vueCategorie = "." + tmp[0];
        var vueSection = "." + tmp[1];

        $(vueCategorie).show();
        $(".livret-section").hide();

        $(vueCategorie + " " + vueSection).show("normal");
    });

    $(".periode-subtitle").on('click', function () {
        $('.periodes-livret').hide();
        $("#formQuinzaine").hide();
        var tmp = $(this).data("vue").split(" ");
        var vuePeriode = "." + tmp[0];
        var vueType = "." + tmp[1];

        $(vuePeriode).show();
        $('.entreprise, .formation, .tuteur').hide();

        $(vuePeriode + " " + vueType).show("normal");

    });

    $('.c1').show();
    $(".livret-section").hide();
    $('.i1').show();
    $('.p1').show();
    $('.entreprise, .formation, .tuteur').hide();
    $('.p1 .formation').show();


    $(".ajouterQuinzaine").on('click', function () {
        $('.periodes-livret').hide();
        $("#formQuinzaine").show();
    })

    $('.saveLivret').on('focusout', function () {
        var item = $(this).data("item");
        var livret = $(this).data("livret");
        var categorie = $(this).data("categorie");
        var section = $(this).data("section");
        var key = $(this).data("key");
        var value = $(this).val();

        if (value == "") {
            return false;
        }

        // Serialization des data
        var json = JSON.stringify({
            "jsonrpc": "2.0",
            "method": "POST",
            "data": {
                "item": item,
                "livret": livret,
                "categorie": categorie,
                "section": section,
                "key": key,
                "value": value
            }
        });


        // Construction de l'url, on enlève les éventuels #!
        var url = window.location.href.replace("#!");
        url += "/saveLivret";

        $.ajax(
            {
                url: url,
                type: "POST",
                dataType: "JSON",
                data: json,
                headers: {
                    'content-type': "application/json; charset=utf-8"
                },
                success: function (data) {
                    toast('Enregistrement réussi!');
                },
                error: function() {
                    toast('Erreur lors de l\'enregistrement');
                }
            }
        )
    })

});


function toast(msg) {
    return Materialize.toast(msg, 4000);
}