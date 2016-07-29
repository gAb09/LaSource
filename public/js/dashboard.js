/**
 * Acquisition du du contenu composer mail
 *
 * @param   
**/
function getComposerMailContent()
{
    var ad = 'http://lasource/dashboard/composerMails';
    var cible = $('#composer_mails');
    $.ajax({
        url : ad,
        type : 'GET',
        dataType : 'html',
        success : function(code_html, statut){
            cible.empty();
            $(code_html).appendTo(cible);
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

