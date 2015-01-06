define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var UserCollection = Backbone.Collection.extend({
        url:'/dev/users'
    });

    var UserModel = Backbone.Model.extend({
        urlRoot:'/dev/users'
    });

    return {
        UserCollection:UserCollection,
        UserModel:UserModel
    };
});