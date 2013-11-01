function findStore(value, value2, value3, value4, value5)
{
	if(value == "")
	{	
		document.getElementById('explain').innerHTML='Search for a Store here or choose one below...';
	}

	$.post("php/storesearch.php", {partialStore:value, searchQuery:true, causeAbrv:value2, temp:value5, causeAID:value3, ref:value4},function(data)
	{
		$("#results").html(data);
	});
}

function findCause(value, value2)
{
	if(value == "")
	{	
		document.getElementById('explain').innerHTML='Search for a Cause here or choose one below...';
	}

	value = value.replace("'","");
	$.post("php/causesearch.php", {partialCause:value, ref:value2, searchQuery:true},function(data)
	{
		$("#results").html(data);
	});
	
}

function findCauseE(value, value2, value3)
{
	if(value == "")
	{	
		document.getElementById('explain').innerHTML='Search for a Cause here or choose one below...';
	}

	value = value.replace("'","");
	$.post("php/causesearche.php", {store:value, partialCause:value2, ref:value3, searchQuery:true},function(data)
	{
		$("#results").html(data);
	});
	
}

function loadContentCause(value2, value3, value4, value5)
{
	document.searchform.searchbar.focus();
	$.post("php/storesearch.php", {partialStore:"", searchQuery:false, causeAbrv:value2, causeAID:value3, ref:value4, temp: value5},function(data)
	{
		$("#results").html(data);
	});
}

function loadContentIndex(value2)
{
	document.searchform.searchbar.focus();
	$.post("php/causesearch.php", {partialStore:"", ref:value2, searchQuery:false},function(data)
	{
		$("#results").html(data);
	});
}

function loadContentIndexE(value2, value3)
{
	var wait = setInterval(function(){document.searchform.searchbar.focus();window.clearInterval(wait);},100);
	
	$.post("php/causesearche.php", {store:value3, ref:value2, searchQuery:false},function(data)
	{
		$("#results").html(data);
	});
	
	
}

function clearSearch(e)
{
	document.getElementById('explain').innerHTML='';
	var key;      
	if(window.event)
	  key = window.event.keyCode;
	else
	  key = e.which;

	return (key != 13);
}

function recordClick(str)
{
	alert(str);
}

function focusSearch()
{
	document.searchform.searchbar.focus();
}


