define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var RestaurantCollection = Backbone.Collection.extend({
        url:'/dev/restaurants'
    });

    var RestaurantModel = Backbone.Model.extend({
        urlRoot:'/dev/restaurants'
    });

    return {
        RestaurantCollection:RestaurantCollection,
        RestaurantModel:RestaurantModel
    };
});