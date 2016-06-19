function gererVolet(item)
{
	if (item.className == "col-md-6 footer2 open") {
		item.className = "col-md-6 footer2 closed";
	}else{
		item.className = "col-md-6 footer2 open";
	}
}