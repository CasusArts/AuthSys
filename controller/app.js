/**
 *
 * @author Andriy Oblivantsev <eslider@gmail.com>
 * @copyright 16.05.2015 by WhereGroup GmbH & Co. KG
 */
$(function(){

    window.application = new function() {

        /**
         * Request api
         */
        this.query = function(act, request) {
            request.act = act;

            return $.ajax({
                url:  "api.php",
                data: request,
                dataType: "json"
            });
        };

        this.registration = function(userName, password) {
            return this.query("registration", {user: userName, pass: password});
        };

        this.login = function(userName, password ){
            return this.query("login", {user: userName, pass: password});
        }
    };

    //var request = {asdasd: "xxx"};
    //var token = application.query(request);
    //
    //
    //token.done(function(responce) {
    //    console.log(responce);
    //})


});