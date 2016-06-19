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