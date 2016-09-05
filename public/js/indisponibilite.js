$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

$(function()
{
    $("#datepicker_debut").datepicker({
        dateFormat: "DD d M yy",
        altField: "#date_debut",
        altFormat: "yy-mm-dd",
        showOn: "button",
        buttonText: "Choisir une date de début",
        onClose: function(valeur, dp) {$('#date_debut_enclair').empty().append($('#datepicker_debut').val());},
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
        onClose: function(valeur, dp) {$('#date_fin_enclair').empty().append($('#datepicker_fin').val());},
    });
});

