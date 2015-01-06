define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var LoginModel = Backbone.Model.extend({
        urlRoot:'/dev/login'
    });

    return {
        LoginModel:LoginModel
    };
});