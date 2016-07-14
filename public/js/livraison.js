$(function()
{
  $("#date_cloture").datepicker({
    dateFormat: "yy-mm-dd",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(date, dp) {var nom = 'date_cloture'; getDates(nom, date);},
  });
});


$(function()
{
  $("#date_paiement").datepicker({
    dateFormat: "yy-mm-dd",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(date, dp) {var nom = 'date_paiement'; getDates(nom, date);},
  });
});


$(function()
{
  $("#date_livraison").datepicker({
    dateFormat: "yy-mm-dd",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(date, dp) {var nom = 'date_livraison'; getDates(nom, date);},
  });
});


/*
| Acquisition du contenu html pour les dates
|
*/
function getDates(nom, date)
{
  var ad = 'http://lasource/livraison/date/'+nom+'/'+date;
var cible = '#div_'+nom;
alert(cible);
  $.ajax({
   url : ad,
   type : 'GET',
   dataType : 'html',
   success : function(code_html, statut){
     $("#div_"+nom).empty().append(code_html);
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

/*
| Acquisition du contenu html pour la vue modale : listProducteursForPanier
|
*/
function listProducteursForPanier(idpanier)
{
  var ad = 'http://lasource/livraison/panier/' + idpanier + '/listProducteurs';

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

/**
* Acquisition du contenu html pour la vue modale : listPaniers
*
* @param 
**/
function listPaniers(livraison_id)
{
  var ad = 'http://lasource/livraison/' + livraison_id + '/listpaniers';

  $.ajax({
   url : ad,
   type : 'GET',
   dataType : 'html',
   success : function(code_html, statut){
     $(code_html).appendTo("#ModallistPaniers");
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

function reporterValeur(input)
{
  var valeur = $(input).val();
  // alert( valeur );
  $(input).parents('tr').find('#prixlivraison').val(valeur);
}


function toggleLied(panier)
{
  if($( panier ).hasClass( "lied" )){
    $( panier ).removeClass( "lied" );
    $(panier).children('input').prop('checked', false);
  }else{
    $( panier ).addClass( "lied" );
    $(panier).children('input').prop('checked', true);
  }

}


