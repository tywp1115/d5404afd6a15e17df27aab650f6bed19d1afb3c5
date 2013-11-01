function loadCauses(value)
{
	$("#box1").html(value);
	$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
	//document.getElementById('load').style.visibility="visible";
	$.post("php/listc.php", {},function(data)
	{
		$("#results").html(data);
		$("#box1").html(value);
	});
}
function loadStores(value)
{
	$("#box1").html(value);
	$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
	//document.getElementById('load').style.visibility="visible";
	$.post("php/lists.php", {},function(data)
	{
		$("#results").html(data);
		$("#box1").html(value);
	});
	
}