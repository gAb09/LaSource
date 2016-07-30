
function getXMLHttpRequest() {
	var xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest();
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}

	return xhr;
}



function gererVolet(item)
{
	if (item.className == "col-md-6 footer2 open") {
		$(item).addClass( "col-md-6 footer2 closed" );
		// item.className = "col-md-6 footer2 closed";
	}else{
		// item.className = "col-md-6 footer2 open";
		$(item).addClass( "col-md-6 footer2 open" );
	}
}

function handleIsActifClass()
{
	var item = $('.toggle_actif');
	console.log(item);

	$(item).toggleClass('is_not_actif').toggleClass('is_actif');
}




function setRangs(model, tablo){

// console.log('model : '+model);
// console.log('tablo : '+tablo);

var ad = 'setrangs/'+model;
$.ajax({
	url : ad,
	contentType : 'text/json',
	type : 'GET',
	data : {'tablo' : tablo},
	dataType : 'html',
	success : function(code_html, data, statut){
		console.log(code_html);
		$('#messages').empty().append(code_html);
	},

	error : function(data, resultat, statut, erreur){
		console.log(data);
		console.log(resultat);
		console.log(statut);
		console.log(erreur);
	},

});

}
