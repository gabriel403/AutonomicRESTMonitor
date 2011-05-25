dojo.require("dijit.form.ComboButton");
dojo.require("dijit.MenuItem");
dojo.require("dijit.Menu");
dojo.require("dojo.parser");

dojo.addOnLoad(adminOnLoadFunc);

function adminOnLoadFunc() {
	dojo.query(".dijitComboButton").forEach(function(item){
		dojo.parser.parse(item);
	});
	dojo.query(".dijitComboButton").style("padding", "2px");
	dojo.query("form dd").forEach(function(item, index){
		if ( index == 2 || index == 5 || index == 8 )
			dojo.create("br", {
				"style":"clear:both"
			}, item, "after");
	});
	
	dojo.query("form").forEach(function(item){
		dojo.create("br", {"style":"clear:both"}, item);
	});
	dojo.style("contentDiv", "display", "block");
}

function editDelete(id, type) {
	pathname = window.location.pathname; 
	pathname = "/" == pathname[0]?pathname.substr(1):pathname;
	pathsplit = pathname.split("/");
	switch(type) {
		case "edit":
			window.location = "/"+pathsplit[0]+"/edit/"+pathsplit[2]+"/"+id;
			break;
		case "delete":
			var answer = confirm("Do you really want to delete this item?")
			if (answer) 
				doDelete(id, pathsplit[2]);
			break;
			
	}
}

function doDelete(id, type)
{
	dojo.xhrPost
	({
		url: '/admin/delete/'+type+'/'+id,
		load: function(data)
		{
			if ( "SUCCESS" == data )
				window.location = window.location;
			else
				dojo.attr("errormsg", "innerHTML", "There was a problem deleting this item.");
		}
	});
}