dojo.addOnLoad(onloader);

function onloader (e) {
    
    dojo.connect(dojo.byId("Login"), "onsubmit", function(e){
        e.preventDefault();
        var form = dijit.byId("Login");
        if (!form.validate()) {
            return false;
        }
        dojo.xhrPost
        ({
            url: '/admin/login/login',
            form: dojo.byId("Login"),
            load: function(data)
            {
                if ( "NOTVALIDATED" == data )
                    dojo.attr("errormsg", "innerHTML", "There was a problem \n\
				processing your login request.<br />Please check your username \n\
				and password are correct and try again.");
                else if ( "VALIDATED" == data )
                    window.location = "/admin/";
            }
        });
        
    });
}