$(function()
{
    $("#datepicker_cloture").datepicker({
        dateFormat: "yy-mm-dd",
        altField: "#date_cloture",
        altFormat: "yy-m-d",
        showOn: "button",
        buttonText: "Choisir",
        onClose: function(valeur, dp) {var nom = 'date_cloture'; getComboDates(nom, valeur);},
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
        onClose: function(valeur, dp) {var nom = 'date_paiement'; getComboDates(nom, valeur);},
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
        onClose: function(valeur, dp) {var nom = 'date_livraison'; getComboDates(nom, valeur);},
    });
});


/*
| Acquisition du contenu html pour les dates
|
*/
function getComboDates(nom, valeur)
{
    valeur = valeur.split(" ")[0];
    if (valeur === '') {valeur = 0;}

    var ad = domaine+'/livraison/combodate/'+valeur;
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
            // alert(statut);
            // alert(erreur);
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

    if (change_detected) {
        var message = "Attention vous avez apporté des modifications sur des paniers sans les avoir validées.";
        message =  message+"\nSi vous cliquez sur Ok, vous accéderez à la liste des producteurs, mais ces modifications seront perdues.";
        message +=  "\nPour les valider, il faut annuler, puis “Valider ces paniers”, et ensuite redemandez la liste pour un ajout.";
        var box = confirm(message);
        if (!box) {return false;}
    }

    resetChangeDetected();

    var ad = domaine+'/livraison/panier/' + idpanier + '/listProducteurs';

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
    if (change_detected) {
        var message = "Attention vous avez apporté des modifications sur les paniers sans les avoir validées.";
        message =  message+"\nSi vous cliquez sur Ok, vous accéderez à la liste des paniers, mais ces modifications seront perdues.";
        message +=  "\nPour les valider, il faut annuler, puis “Valider ces paniers”, et ensuite redemandez la liste pour un ajout.";
        var box = confirm(message);
        if (!box) {return false;}
    }

    resetChangeDetected();


    var ad = domaine+'/livraison/' + livraison_id + '/listpaniers';

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


var change_detected = false;


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
        changementDatasPaniersDetected(input_livraison);
    }
}

console.log(change_detected);


/**
* Alerte si des modifications apportées à un (plusieurs) panier(s) n'ont pas été validées.
* Annulation possible.
*
**/
function changementDatasPaniersDetected(item){
    $(item).addClass('changed');
    console.log(change_detected);
    change_detected = true;

}

function resetChangeDetected(){
    var items = $( ".changed" );
    $(items).each(function() {
        $( this ).removeClass('changed');
    });
    change_detected = false;
    console.log(change_detected);
}


window.onbeforeunload = function(){

    if ($( ".changed" ).length !== 0) {
        console.log('des changements');
        change_detected = true;
    }else{
        console.log('pas de changements');
        change_detected = false;
    }
    console.log(change_detected);


    if (change_detected) {
        return "Atention. Un changement de prix ou de producteur affecté à un panier n'a pas été validé.";
    }
};






function attachRelais(relais_id)
{
    var target = document.getElementById('input_'+relais_id);
    var indispoPourLivraison = document.getElementsByName('IndispoPourLivraison_'+relais_id)[0];

    console.log('target : '+target);
    console.log('indispoPourLivraison : '+indispoPourLivraison);

    if(indispoPourLivraison){
        alert('Attention ! Ce relais ne peut pas être lié à cause de son indisponibilité à la date de livraison');
    }else{
        target.value=1;
        console.log(target.id+' : '+target.value);
        document.getElementsByName('relaisForm')[0].submit();
    }

}

function detachRelais(relais_id)
{
    var target = document.getElementById('input_'+relais_id);
    target.value=0;
    console.log(target.id+' : '+target.value);
}



function attachModepaiement(modepaiement_id)
{
    var target = document.getElementById('input_modepaiement_'+modepaiement_id);
    var indispoPourLivraison = document.getElementsByName('IndispoPourLivraison_'+modepaiement_id)[0];

    console.log('target : '+target);
    console.log('indispoPourLivraison : '+indispoPourLivraison);

    if(indispoPourLivraison){
        alert('Attention ! Ce mode de paiement ne peut pas être lié à cause de son indisponibilité à la date de livraison');
    }else{
        target.value=1;
        console.log(target.id+' : '+target.value);
        document.getElementsByName('paiementForm')[0].submit();
    }

}

function detachModepaiement(modepaiement_id)
{
    var target = document.getElementById('input_modepaiement_'+modepaiement_id);
    target.value=0;
    console.log(target.id+' : '+target.value);
}
