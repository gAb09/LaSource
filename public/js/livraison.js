$(function()
{
    $("#datepicker_cloture").datepicker({
        dateFormat: "yy-mm-dd",
        altField: "#date_cloture",
        altFormat: "yy-m-d",
        showOn: "button",
        buttonText: "Choisir",
        onClose: function(valeur, dp) {var nom = 'date_cloture'; getComboDatesLivraison(nom, valeur);},
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
        onClose: function(valeur, dp) {var nom = 'date_paiement'; getComboDatesLivraison(nom, valeur);},
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
        onClose: function(valeur, dp) {var nom = 'date_livraison'; getComboDatesLivraison(nom, valeur);},
    });
});


/*
| Acquisition du contenu html pour les dates
|
*/
function getComboDatesLivraison(nom, valeur)
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
            // alert(resultat);
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

    if (changed) {
        var box = confirm("Attention vous avez apporté des modifications sur les paniers. \nSi vous cliquez sur Ok, vous accéderez à la liste des producteurs, mais ces modifications seront perdues.");
        if (!box) {return false;}
    }

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
* Vider la modale listProducteurs à sa fermeture
*
* @param 
**/
$('#ModallistProducteursForPanier').on('hidden.bs.modal', function () {
    $('#ModallistProducteursForPanier').empty();
});


/**
* Acquisition du contenu html pour la vue modale : listPaniers
*
* @param 
**/
function listPaniers(livraison_id)
{
    if (changed) {
        var box = confirm("Attention vous avez apporté des modifications sur les paniers. \nSi vous cliquez sur Ok, vous accéderez à la liste des paniers, mais ces modifications seront perdues.");
        if (!box) {return false;}
    }

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


/**
* Vider la modale listPaniers à sa fermeture
*
* @param 
**/
$('#ModallistPaniers').on('hidden.bs.modal', function () {
    $('#ModallistPaniers').empty();
});




/**
* Report du prix de base dans l'input .prixlivraison
*
* @param 
**/
function reporterPrixBase(input)
{
    var prix_base = $(input).val();
    var input_livraison = $(input).parents('tr').find('.prixlivraison');
    // alert( input_livraison.val() );
    // alert( prix_base );
    // alert(input_livraison.val() === prix_base);
    if (input_livraison.val() !== prix_base){
        input_livraison.val(prix_base);
        detectChangementDatasPaniers();
    }
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


/**
* Alerte si des modifications apportées à un (plusieurs) panier(s) n'ont pas été validées.
* Annulation possible.
* 
**/
var changed = 0;

function detectChangementDatasPaniers()
{
    changed = true;
    // alert('changement : ' + changed);
}


$(function()
{
    $(".producteur").change(function(){
        detectChangementDatasPaniers();
    });
});

$(function()
{
    $(".prixlivraison").change(function(){
        detectChangementDatasPaniers();
    });
});

function attachRelais(relais_id, indispoLivraison)
{
    var target = document.getElementById('input_'+relais_id);
    var indispoPourLivraison = document.getElementsByName('IndispoPourLivraison_'+relais_id)[0];
        console.log(indispoPourLivraison);
    if(indispoPourLivraison){
        alert('Attention ! Ce relais ne peut pas tre lié à cause de son indisponibilité à la date de livraison');
        
    }else{
        target.value=1;
        console.log(target.id+' : '+target.value);
        document.getElementsByName('relaisForm')[0].submit()
    }

}

function detachRelais(relais_id)
{
    var target = document.getElementById('input_'+relais_id);
    target.value=0;
    console.log(target.id+' : '+target.value);
}

