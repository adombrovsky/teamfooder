define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var notificationCollection = new Backbone.Collection();

    return {
        notificationCollection:notificationCollection
    };
});