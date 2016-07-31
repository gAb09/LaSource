
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
