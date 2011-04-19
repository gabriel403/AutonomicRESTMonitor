dojo.addOnLoad(onloader);

function onloader (e) {
    dojo.connect(dojo.byId("Login"), "onsubmit", function(e){
        e.preventDefault();
        dojo.xhrPost
        ({
            url: '/default/auth/auth',
            form: dojo.byId("Login"),
            load: function(data)
            {}
        });
        
    });
}