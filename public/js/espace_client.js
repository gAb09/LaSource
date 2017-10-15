function select(livraison, model, item, valeur){

	checked_actuel = $("span[livraison="+livraison+"][model="+model+"][class$='checked']");

	if (livraison === '0') {
		reporteValeurDefaut(model, $(item).attr('name'), valeur);
	}else{
		if ($(checked_actuel).attr('name') != $(item).attr('name')) {
			$(item).addClass('checked');
			$(checked_actuel).removeClass('checked');
			changeSiblingInput(livraison, model, valeur);
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
