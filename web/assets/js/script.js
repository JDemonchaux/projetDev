$(document).ready(function () {
    var isChanged = "";

    clickableCell();
    $('.modal-trigger').leanModal();
    $('.dropdown-button').dropdown();
    $('.collapsible').collapsible({
        accordion: true
    });
    $(".button-collapse").sideNav();
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
    $('.choixApprenti, #tableCompetences').dataTable({
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
    $('#formAddItemFormation').hide();
    $('#formAddItemEntreprise').hide();

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
        $("#formAddItemFormation").hide();
        $("#formAddItemEntreprise").hide();
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
        $('#formAddItemFormation').hide();
        $("#formQuinzaine").show();
    });

    $('.saveLivret').on('focus', function () {
        isChanged = $(this).val();
    });

    $('.saveLivret').on('focusout', function () {
        var item = $(this).data("item");
        var livret = $(this).data("livret");
        var categorie = $(this).data("categorie");
        var section = $(this).data("section");
        var key = $(this).data("key");
        var value = $(this).val();

        if (value == isChanged) {
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
        var url = window.location.href.replace("#!", "");
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
                error: function () {
                    toast('Erreur lors de l\'enregistrement');
                }
            }
        )
    });

    $('.btSigner').on('click', function () {
        var item = $(this).data("item");
        var livret = $(this).data("livret");
        var categorie = $(this).data("categorie");
        var section = $(this).data("section");
        var key = $(this).data("key");

        // Serialization des data
        var json = JSON.stringify({
            "jsonrpc": "2.0",
            "method": "POST",
            "data": {
                "item": item,
                "livret": livret,
                "categorie": categorie,
                "section": section,
                "key": key
            }
        });

        // Construction de l'url, on enlève les éventuels #!
        var url = window.location.href.replace("#!", "");
        url += "/signer";
        console.log(window.location.href);
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
                error: function () {
                    toast('Erreur lors de l\'enregistrement');
                }
            }
        )


    });

    $("#formFile").on('submit', function () {
        var filename = $(".insertFile").val();
        var item = $(this).data("item");
        var livret = $(this).data("livret");
        var categorie = $(this).data("categorie");
        var section = $(this).data("section");
        var key = $(this).data("key");

        var url = window.location.href.replace("#!", "");
        var url = window.location.href.replace("_submit=", "");
        var url = window.location.href.replace("?", "");
        url += "/fichier";

        var input = document.getElementsByClassName("insertFile");

        var formData = new FormData();
        formData.append("userfile", input[0].files[0]);
        formData.append("item", item);
        formData.append("livret", livret);
        formData.append("categorie", categorie);
        formData.append("section", section);
        formData.append("key", key);
        formData.append("value", filename);

        console.log(url);

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                toast('Enregistrement réussi!');
            },
            error: function () {
                toast('Erreur lors de l\'enregistrement');
            },
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });


    // Bouton ajout de ligne dans les fiches de quinzaines
    $(".addLine-formation > button").on("click", function () {
        var idPeriode = $(this).data("periode");

        $(".periodes-livret").hide();
        $("#formAddItemFormation").show();
        $("#formAddItemFormation>div>form").append('<input type="hidden" name="idPeriode" value="' + idPeriode + '" />');
    });
    $(".addLine-entreprise > button").on("click", function () {
        var idPeriode = $(this).data("periode");
        $(".periodes-livret").hide();
        $("#formAddItemEntreprise").show();
        $("#formAddItemEntreprise>div>form").append('<input type="hidden" name="idPeriode" value="' + idPeriode + '" />');
    });


    // Bouton retirer une ligne
    $(".removeLine > button").on('click', function () {
        /*
         var l = $(this).data("line");
         $("."+l).remove();
         */
    });

    $('.formationAdd').on('submit', function () {

    });


    $('.btn-ajout-competence').on('click', function () {
        console.log("ici");
        var c = [];
        $('.competence-selected').each(function () {
            var item = $(this).find(".comp").html();
            var comp = item.split(" - ");
            $('.competence-ajoutee>tbody').append('<tr>' +
                '<td>' + comp +
                '</td>' +
                '</tr>');
            $(".inputHidden").append('<input type="hidden" name="comp[]" value="' + comp[0] + '" />');
        });

    });

    $(".paginate-button").on('click', function () {
        clickableCell();
    });

    $(".element-checkable>.checkable").on('click', function () {
        $(this).parent().children().each(function () {
            if ($(this).hasClass("checked")) {
                $(this).removeClass("checked");
            }
        });
        $(this).addClass("checked");

        var degreMaitrise = $(this).data("maitrise");
        var idComp = $(this).parent().data("idcomp");
        var idLivret = $(this).parent().data("idlivret");
        var idPeriode = $(this).parent().data("idperiode");
        var idItem = $(this).parent().data("iditem");
        var url = $(this).parent().data("url");

        var json = JSON.stringify({
            "jsonrpc": "2.0",
            "method": "POST",
            "data": {
                "degreMaitrise": degreMaitrise,
                "idComp": idComp,
                "idLivret": idLivret,
                "idPeriode": idPeriode,
                "idItem": idItem
            }
        });

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
                error: function () {
                    toast('Erreur lors de l\'enregistrement');
                }
            }
        )
    });

    $('.saveDescriptionComp').on('focus', function () {
        isChanged = $(this).val();
    });

    $(".saveDescriptionComp").on("focusout", function () {
        var description = $(this).val();

        if (description == isChanged) {
            return false;
        }

        var idComp = $(this).data("idcomp");
        var idLivret = $(this).data("idlivret");
        var url = $(this).data("url");

        var json = JSON.stringify({
            "jsonrpc": "2.0",
            "method": "POST",
            "data": {
                "description": description,
                "idComp": idComp,
                "idLivret": idLivret
            }
        });

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
                error: function () {
                    toast('Erreur lors de l\'enregistrement');
                }
            }
        )
    })

});


function toast(msg) {
    return Materialize.toast(msg, 4000);
}

function clickableCell() {
    // Gestion du tableau d'ajout de competence. Dans quinzaine entreprise
    $(".competence-element>td").on('click', function () {
        if ($(this).parent().hasClass("competence-selected")) {
            $(this).parent().removeClass("competence-selected");
        } else {
            $(this).parent().addClass("competence-selected");
        }
    });
}