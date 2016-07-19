$(function()
{
  $("#datepicker_cloture").datepicker({
    dateFormat: "yy-mm-dd",
    altField: "#date_cloture",
    altFormat: "yy-m-d",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(valeur, dp) {var nom = 'date_cloture'; getComboDate(nom, valeur);},
  });
});


$(function()
{
  $("#datepicker_paiement").datepicker({
    dateFormat: "yy-mm-dd",
    altField: "#date_paiement",
    altFormat: "yy-m-d",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(valeur, dp) {var nom = 'date_paiement'; getComboDate(nom, valeur);},
  });
});


$(function()
{
  $("#datepicker_livraison").datepicker({
    dateFormat: "yy-mm-dd",
    altField: "#date_livraison",
    altFormat: "yy-m-d",
    showOn: "button",
    buttonText: "Choisir",
    onClose: function(valeur, dp) {var nom = 'date_livraison'; getComboDate(nom, valeur);},
  });
});

function getComboCloture(valeur)
{

}


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


