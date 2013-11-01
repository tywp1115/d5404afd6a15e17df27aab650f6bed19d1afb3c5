function link()
{
	var item = chrome.extension.getBackgroundPage().storeid;
	
	chrome.tabs.getSelected(null, function(tab) 
	{
	  chrome.tabs.sendMessage(tab.id, {index: item, redirect: 1}, function(response) 
	  {
		console.log(response.farewell);
	  });
	});
	setInterval(function(){window.close()},100);
}    

function init() 
{
    dialog = document.querySelector('#content');
    dialog.addEventListener('click', link, false);
}    

document.addEventListener('DOMContentLoaded', init);