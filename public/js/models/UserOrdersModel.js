define([
    'jquery',
    'backbone',
], function($, Backbone) {
    var UserOrdersModel = Backbone.Model.extend({
        urlRoot:'/dev/userorders',
        //url:function()
        //{
        //    return '/dev/userorders'+(this.isNew()?'':'/'+this.get('id'))
        //}
    });

    var UserOrdersCollection = Backbone.Collection.extend({
        instanceUrl: '/dev/userorders/byRequest',
        url: function(){
            return this.instanceUrl;
        },
        initialize: function(props)
        {
            if (props && props.url)
            {
                this.instanceUrl = props.url;
            }
        },
        model:UserOrdersModel
    });

    return {
        UserOrdersCollection:UserOrdersCollection,
        UserOrdersModel:UserOrdersModel
    };
});