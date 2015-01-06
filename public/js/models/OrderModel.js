define([
    'jquery',
    'backbone',
], function($, Backbone) {

    var OrderUsersCollection = Backbone.Collection.extend({
        instanceUrl:null,
        url: function(){
            return this.instanceUrl;
        },
        initialize: function(props)
        {
            if (props && props.url)
            {
                this.instanceUrl = props.url;
            }
        }
    });

    var OrderModel = Backbone.Model.extend({
        urlRoot:'/dev/orders'
    });

    var OrderCollection = Backbone.Collection.extend({
        url:'/dev/orders',
        model:OrderModel
    });

    return {
        OrderCollection:OrderCollection,
        OrderModel:OrderModel,
        OrderUsersCollection:OrderUsersCollection,
    };
});