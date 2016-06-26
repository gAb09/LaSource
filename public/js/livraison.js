function edit(numero_ligne) {

	var request = getXMLHttpRequest();
	var url = document.location.pathname+'/';
	var ligne = document.getElementById('row_' + numero_ligne);
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


function createLivraison() {
	var tablebody = document.getElementById('tablebody');
	var request = getXMLHttpRequest();
	var url = document.location.pathname+'/create';
	ligne = document.createElement("div");
	first = tablebody.firstChild;

	// ligne.className = ligne.className+' flexcontainer';
	tablebody.insertBefore(ligne, tablebody.childNodes[0]);

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

	request.open('GET', url, true);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	request.send(null);
}

