function gererVolet(item)
{
	if (item.className == "col-md-12 footer open") {
		item.className = "col-md-12 footer closed";
	}else{
		item.className = "col-md-12 footer open";
	}
}