/**
 *
 * @author Andriy Oblivantsev <eslider@gmail.com>
 */
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
        this.registration = function(userName, password) {
            return this.query("registration", {
                user: userName,
                pass: password
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
                pass: password
            }).done(function(response) {
                if(response.user != null) {
                    if(onLogin) {
                        onLogin(response.user)
                    }
                    $.notify("User is logged on.", "info");
                } else {

                    $.notify("User or password is incorrect.");
                }
            });
        }
    };

});