define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var MealCollection = Backbone.Collection.extend({
        instanceUrl:'/dev/meals/byOrder/',
        url: function(){
            return this.instanceUrl;
        },
        initialize: function(props)
        {
            if (props && props.orderId)
            {
                this.instanceUrl += props.orderId;
            }
        }
    });

    var MealModel = Backbone.Model.extend({
        urlRoot:'/dev/meals'
    });

    return {
        MealCollection:MealCollection,
        MealModel:MealModel
    };
});