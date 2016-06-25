function edit(ligne, numero_ligne) {
// alert(numero_ligne);
	// handleTetiere(numero_ligne, 'add');

	var request = getXMLHttpRequest();
	var url = document.location.pathname+'/';
alert(url);
	ligne.className = ligne.className+' edit';

	request.onreadystatechange = function() {
		if (request.readyState == 4 && (request.status == 200 || request.status === 0)) {
			if (request.responseText) {
				response = request.responseText;
				ligne.innerHTML = response;
			} else {
				alert('pas OK');
			}
		}
	};

	request.open('GET', url + numero_ligne + '/edit', true);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	request.send(null);
}


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


