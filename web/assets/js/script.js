$(document).ready(function () {
    $('.dropdown-button').dropdown();
    $('.collapsible').collapsible({
        accordion: true
    });
    $('.modal-trigger').leanModal();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    $(".livret_section, .categories").hide();

    $(".sections").on('click', function () {
        $(".categories").hide();
        var tmp = $(this).data("vue").split(" ");
        var vueCategorie = "." + tmp[0];
        var vueSection = "." + tmp[1];
        console.log(vueCategorie);
        console.log(vueSection);

        $(vueCategorie).show();
        $(".livret-section").hide();

        $(vueCategorie + " " + vueSection).show("normal");
    });


    /**
     * Style du menu
     */
    $(".categorie-title").first().addClass("border-top");


    /**
     * Affichage du livret en consultation
     */
    $('.c1').show();
    $(".livret-section").hide();
    $('.i1').show();

    var c = $("table").data("columns");
    var l = $("table").data("rows");
    var t = 0;

    $(".item-tableau").each(function () {
        t = $(this).find("tbody tr").length;
        var arr = new Array();
        $(this).find("tbody tr").each(function () {
            arr.push($(this).find(".text").text());

            // Si la taille est égale aux nb de ligne, on touche rien
            if (t != l) {
                // Sinon, on regarde si la taille est divisible par le nb de ligne (ainsi on aura pas de cases vides)
                //if (t % l == 0) {
                    console.log(t);
                //}
            }
            else if ( t < l) {
            }

        });
    });

});