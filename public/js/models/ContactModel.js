define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var ContactCollection = Backbone.Collection.extend({
        url:'/dev/contacts'
    });

    return {
        ContactCollection:ContactCollection,
    };
});