var storeid = -1;

chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {
	if(request.jgrowl == 1)
	{
		$.jGrowl('<center>This store is on Jatna!<br/><br/>Click the leaf in the address bar to fundraise.</center>');
	}	
});


function shorten()
{
	var path = new String(window.location);
	if(path.indexOf(".com") != -1)
	path = path.substring(0, path.indexOf(".com")+4);
	else if(path.indexOf(".net") != -1)
	path = path.substring(0, path.indexOf(".net")+4);
	else if(path.indexOf(".org") != -1)
	path = path.substring(0, path.indexOf(".org")+4);
	else if(path.indexOf(".gov") != -1)
	path = path.substring(0, path.indexOf(".gov")+4);
	else if(path.indexOf(".biz") != -1)
	path = path.substring(0, path.indexOf(".biz")+4);
	else if(path.indexOf(".edu") != -1)
	path = path.substring(0, path.indexOf(".edu")+4);
	else if(path.indexOf(".int") != -1)
	path = path.substring(0, path.indexOf(".int")+4);
	else if(path.indexOf(".mil") != -1)
	path = path.substring(0, path.indexOf(".mil")+4);
	else if(path.indexOf(".info") != -1)
	path = path.substring(0, path.indexOf(".info")+5);
	else if(path.indexOf(".jobs") != -1)
	path = path.substring(0, path.indexOf(".jobs")+5);
	else if(path.indexOf(".mobi") != -1)
	path = path.substring(0, path.indexOf(".mobi")+5);
	else if(path.indexOf(".name") != -1)
	path = path.substring(0, path.indexOf(".name")+5);
	else if(path.indexOf(".tel") != -1)
	path = path.substring(0, path.indexOf(".tel")+4);
	else if(path.indexOf(".us") != -1)
	path = path.substring(0, path.indexOf(".us")+3);
	else if(path.indexOf(".br") != -1)
	path = path.substring(0, path.indexOf(".br")+3);
	else if(path.indexOf(".ca") != -1)
	path = path.substring(0, path.indexOf(".ca")+3);
	else if(path.indexOf(".cn") != -1)
	path = path.substring(0, path.indexOf(".cn")+3);
	else if(path.indexOf(".fr") != -1)
	path = path.substring(0, path.indexOf(".fr")+3);
	else if(path.indexOf(".in") != -1)
	path = path.substring(0, path.indexOf(".in")+3);
	else if(path.indexOf(".jp") != -1)
	path = path.substring(0, path.indexOf(".jp")+3);
	else if(path.indexOf(".ru") != -1)
	path = path.substring(0, path.indexOf(".ru")+3);
	
	if(path.split(".").length - 1 > 1)
	{
		path = path.substring(path.indexOf(".") + 1, path.length);
	}
	
	else if(path.split("//").length > 1)
	{
		path = path.substring(path.indexOf("//") + 2, path.length);
	}
	
	path = path.replace("/","");
	
	return path;
}

$.get("http://jatna.com/php/ext?l=" + shorten(), 

function(response) 
{ 
	if(response && response != ' |')
	{
		storeid = parseFloat(response);
		chrome.extension.sendRequest({index: storeid, redirect: 0}, function(response) {});
	}
});



chrome.extension.onMessage.addListener(
	function(request, sender, sendResponse) {	
		if(request.redirect == 1)
		{
			window.location = 'http://jatna.com/e?s=' + request.index;
		}
	}
);