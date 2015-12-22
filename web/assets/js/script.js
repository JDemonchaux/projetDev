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

});