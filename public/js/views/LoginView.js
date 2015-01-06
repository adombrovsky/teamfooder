define([
    'jquery',
    'backbone',
    'views/BaseView',
], function($, Backbone, BaseView) {

    var LoginView = BaseView.extend({
        view:'layouts.login',
        events:{
            'click #login_button':'sendForm'
        },
        render:function()
        {
            var self = this;
            self.$el.html(this.template({}));
        },
        sendForm:function(e)
        {
            var data = $(e.target).closest('form').serializeArray();
            var self = this;
            self.cleanErrors();
            for(var a in data)
            {
                if (data.hasOwnProperty(a))
                {
                    self.model.set(data[a].name,data[a].value);
                }
            }

            self.model.save(self.model.attributes,{
                success:function(model,response)
                {
                    location.href = '/orders';
                },
                error:function(model, response)
                {
                    var responseData = JSON.parse(response.responseText);
                    if (typeof responseData.status !== 'undefined' && responseData.status === 'false')
                    {
                        self.highlightErrors(responseData.errors);
                    }
                }
            });
        },
        highlightErrors:function(errors)
        {
            if (typeof errors !== 'undefined')
            {
                for (var a in errors)
                {
                    if (errors.hasOwnProperty(a))
                    {
                        $("#"+a).closest('.form-group').addClass("has-error");
                    }
                }
            }
        },
        cleanErrors:function()
        {
            this.$el.find('.form-group').removeClass("has-error");
        }
    });

    return {
        LoginView:LoginView
    };
});