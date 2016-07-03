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

function ModalChoixProducteurs(toto){

    var ad = 'http://lasource/livraison/choixProducteurs/' + toto;

    $.ajax({
       url : ad,
       type : 'GET',
       dataType : 'html',
       success : function(code_html, statut){
           $(code_html).appendTo("#ModalChoixProducteurs");
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

$('#ModalChoixProducteurs').on('hidden.bs.modal', function (e) {
    $('#ModalChoixProducteurs').text("");
});