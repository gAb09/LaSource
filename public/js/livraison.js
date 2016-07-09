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

function listProducteursForPanier(toto){

    var ad = 'http://lasource/livraison/panier/' + toto + '/listProducteurs';

    $.ajax({
       url : ad,
       type : 'GET',
       dataType : 'html',
       success : function(code_html, statut){
           $(code_html).appendTo("#ModallistProducteursForPanier");
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

$('#ModallistProducteursForPanier').on('hidden.bs.modal', function (e) {
    $('#ModallistProducteursForPanier').text("");
});


function toggleLied(panier){
  if($( panier ).hasClass( "lied" )){
    $( panier ).removeClass( "lied" );
    $(panier).children('input').prop('checked', false);
  }else{
    $( panier ).addClass( "lied" );
    $(panier).children('input').prop('checked', true);
  }

}


