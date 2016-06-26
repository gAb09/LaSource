function edit(ligne, numero_ligne) {

	var request = getXMLHttpRequest();
	var url = document.location.pathname+'/';

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
	tablo = document.getElementById('livraisons');

	var request = getXMLHttpRequest();
	var url = document.location.pathname+'/create';
	ligne = document.createElement("tr");
	first = tablo.firstChild;

	// ligne.className = ligne.className+' flexcontainer';
	tablo.insertBefore(ligne, tablo.childNodes[0]);

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

