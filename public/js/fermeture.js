$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

$(function()
{
    $("#datepicker_debut").datepicker({
        dateFormat: "DD d M yy",
        altField: "#date_debut",
        altFormat: "yy-mm-dd",
        showOn: "button",
        buttonText: "Choisir une date de début",
    });
});


$(function()
{
    $("#datepicker_fin").datepicker({
        dateFormat: "DD d M yy",
        altField: "#date_fin",
        altFormat: "yy-m-d",
        showOn: "button",
        buttonText: "Choisir une date de fin",
        onClose: function(valeur, dp) {var nom = 'date_fin'; getComboDate(nom, valeur);},
    });
});


/*
| Acquisition du contenu html pour les dates
|
*/
function getComboDate(nom, valeur)
{
    valeur = valeur.split(" ")[0];
    if (valeur === '') {valeur = 0;}

    var ad = 'http://lasource/livraison/combodate/'+valeur;
    var span_enclair = '#'+nom+'_enclair';
    var span_delai = '#'+nom+'_delai';
    var input_date = '#'+nom;
    $.ajax({
        url : ad,
        type : 'GET',
        dataType : 'json',
        success : function(data, statut){
            $(span_enclair).empty().append(data['enclair']);
            $(span_delai).empty().append(data['delai']);
            $(input_date).empty().append(data['valeur']);
        },

        error : function(resultat, statut, erreur){
            alert(resultat);
            alert(statut);
            alert(erreur);
        },

        complete : function(resultat, statut){

        }
    });
}


