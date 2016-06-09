/**
 *
 * @author Andriy Oblivantsev <eslider@gmail.com>
 * @author Fiodor Gorobet <casusarts@gmail.com>
 */

// md5 script: https://github.com/emn178/js-md5/

$(function() {

    // create frontend controller to manipulate User inputs

    window.application = new function() {

        /**
         * Request api
         */
        this.query = function(act, request) {

            if(!request) {
                request = {};
            }

            request.act = act;

            return $.ajax({
                url:      "api.php",
                data:     request,
                dataType: "json"
            });
        };

        /**
         * Register user
         *
         * @param userName
         * @param password
         * @returns jQuery ajax token
         */
        
        this.registration = function (userName, password, email) {
            return this.query("registration", {
                user: userName,
                pass: md5(md5(password)),
                email: email
            });
        };

        /**
         * login
         *
         * @param userName
         * @param password
         * @param onLogin login callback
         */
        this.login = function(userName, password, onLogin) {
            this.query("login", {
                user: userName,
                pass: md5(md5(password))
            }).done(function(response) {
                if(response.user != null) {
                    if(onLogin) {
                        onLogin(response.user)
                    }
                    $.notify(response.user.name + " is logged on.", "info");
                } else {

                    $.notify("User or password is incorrect.");
                }
            });
        };

        this.logout = function(){
            this.query("logout");

        };

        this.getLoggedUser = function(){
            this.query("getLoggedUser").done(function(response){
                console.log(response.user);
                $.notify(response.user.name + " is logged on!", "info");
            });
        };

        /**
         * Load View
         */
        this.loadView = function( templateName) {
            return $.ajax({
                url: "Views/" + templateName + ".html"
            });
        };
    };

});
