dojo.require("dijit.form.ComboButton");
dojo.require("dijit.MenuItem");
dojo.require("dijit.Menu");
dojo.require("dojo.parser");

dojo.addOnLoad(onLoadFunc);

function onLoadFunc() {
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

