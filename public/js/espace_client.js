function changeSelect(livraison, model, item, valeur){

	checked_actuel = $("span[livraison="+livraison+"][model="+model+"][class$='checked']");

	if (livraison === '0') {
		reporteValeurDefaut(model, $(item).attr('name'), valeur);
		persisterParametres();
		changementDetected();
	}else{
		if ($(checked_actuel).attr('name') != $(item).attr('name')) {
			$(item).addClass('checked');
			$(checked_actuel).removeClass('checked');
			changeSiblingInput(livraison, model, valeur);
			changementDetected();
		}
	}

	// console.log( $(checked_actuel).attr('livraison')+' - '+$(checked_actuel).attr('name')+' - '+$(checked_actuel).attr('class'));
}


function reporteValeurDefaut(model, nom, valeur){
	var differents = $("[model='"+model+"']");
	$(differents).each(function(index){
		console.log($(this).attr('livraison'));
		$(this).removeClass('checked');
	});

	var idem = $("[name='"+nom+"']");
	$(idem).each(function(index){
		changeSiblingInput($(this).attr('livraison'), model, valeur);
		$(this).addClass('checked');
	});
}


function changeSiblingInput(livraison, model, valeur) {
	var input = $("[name="+livraison+"_"+model+"]");
	$(input).val(valeur);
}


function changementDetected(){
	$("#commande_store").append('<button type="submit" class="btn btn-success" style="float:right;">Vous êtes en train de faire des changements, une fois ceux-ci terminés, cliquez sur cette barre pour les valider</button>');

}

function persisterParametres(argument) {
	// alert('persistance en BDD');
}

function getInputQuantite(span){
	input = span.parentElement.childNodes[5];
	if(isNaN(input.value) || input.value <= 0){
		input.value = 0;
	}
	return input;
}


function increment(span) {
	// console.log('incremente');
	input = getInputQuantite(span);
	input.value++;
	calculTotaux(span, input);
	changementDetected();
}

function decrement(span) {
	// console.log('decrement');
	input = getInputQuantite(span);
	if (input.value >0) {
		input.value--;
		calculTotaux(span, input);
		changementDetected();
	}
}

function calculTotaux(span, input){
	// console.log(input.value);
	div = span.parentElement;
	calculTotalPanier(div, input.value);
	calculTotalLivraison(div);
}

function calculTotalPanier(div, quantite){
	var total_panier = $(div).parent().children(".total_panier");
	var prix_panier = $(div).parent().children(".prix_panier").children(".prix");
	console.log('quantite : '+quantite);
// console.log('calculTotalPanier');
// console.log(total_panier);
console.log(prix_panier.html());
total_panier.html('total panier : '+quantite*prix_panier.html()+' euros');

}

function calculTotalLivraison(div){
	console.log('calculTotalLivraison');
	console.log($(div).parent().parent().parent());
}

function qteChange(input){
	if (input.value < 0) {
		alert('Vous ne pouvez pas saisir des valeurs négatives');
	}else{
		div = input.parentElement;
		console.log('qteChange');
		calculTotalPanier(div, input.value);
		changementDetected();
	}
}

