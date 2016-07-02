$(function() {
    $("#clotureEnClair").datepicker({
        dateFormat: "DD d MM yy",
        altField: "#date_cloture",
        altFormat: "yy-m-d"
    });
});

$(function() {
    $("#paiementEnClair").datepicker({
        dateFormat: "DD d MM yy",
        altField: "#date_paiement",
        altFormat: "yy-m-d"
    });
});

$(function() {
    $("#livraisonEnClair").datepicker({
        dateFormat: "DD d MM yy",
        altField: "#date_livraison",
        altFormat: "yy-m-d"
    });
});
