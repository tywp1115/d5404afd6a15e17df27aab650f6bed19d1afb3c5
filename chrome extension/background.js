var tabid;
var storeid;
var bool = 0;
var d = new Date();
var n = parseFloat(d.getTime());
var time = n - 3600000;

function history(id) 
{
	var searchCriteria = {'text': '', 'maxResults': 0, 'startTime': time};
	
	chrome.history.search(
		searchCriteria,
		function(historyItems) 
		{
			for (var i = 0; i < historyItems.length; ++i) 
			{
				var url = historyItems[i].url;
				
				if(url.indexOf("jatna.com/r?i=" + id) !== -1)
				{
					bool = 1;
				}
			}
			
			if(bool == 0)
			{
				execute();
			}
			
			bool = 0;
		}
	);
}

	

function execute() 
{
	chrome.pageAction.show(tabid);
	chrome.tabs.sendRequest(tabid, {jgrowl: 1}, function(response) 
	{
		console.log(response.data);
	});
}

function onRequest(request, sender, sendResponse) 
{
	d = new Date();
	n = parseFloat(d.getTime());
	
	if(request.redirect == 0)
	{
		tabid = sender.tab.id;
		storeid = request.index;
		history(request.index);
	}
};

chrome.extension.onRequest.addListener(onRequest);