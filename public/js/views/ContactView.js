define([
    'jquery',
    'backbone',
    'moment',
    'views/BaseView',
    'models/ContactModel',
    'datetimepicker',
], function($, Backbone, moment, BaseView) {

    var ContactItem = BaseView.extend({
        view:'contacts._contact',
        tagName:'tr',
        render:function()
        {
            $(this.el).empty();
            $(this.el).html(this.template(this.model.attributes));
            return this;
        }
    });

    var ContactList = BaseView.extend({
        view:'contacts.index',
        events: {
            "click .checkbox-invite-button":"inviteUser"
        },
        initialize: function(options)
        {
            this.options = options;
            this.perPage = this.options.perPage || 150;
            this.page = this.options.page || 0;
            this.$el = $("#friends-list");
        },
        render:function()
        {
            this.fetching = this.collection.fetch();
            var self = this;
            var html=this.template(this.collection.toJSON());
            this.$table=$(html);
            this.fetching.done(function(){
                self.$el.html('');
                self.addContacts();
                self.$el.append(self.$table);
            });
        },
        paginate: function()
        {
            var contacts;
            contacts = this.collection.rest(this.perPage*this.page);
            contacts = _.first(contacts,this.perPage);
            return contacts;
        },
        addContacts: function()
        {
            var contacts = this.paginate();
            for(var i=0;i<contacts.length;i++)
            {
                this.addOneContact(contacts[i]);
            }
        },
        addOneContact:function(model)
        {
            var view = new ContactItem({model:model});
            this.$table.append(view.render().el);
        },
        inviteUser:function(e)
        {
            var el = $(e.target);
            var model = this.collection.findWhere({id:el.data('id')});
            if (el.data('checked') > 0)
            {
                el.addClass('btn-primary').removeClass('btn-success').text('Invite');
                el.data('checked',0);
                model.set('checked',0);
            }
            else
            {
                el.removeClass('btn-primary').addClass('btn-success').text('Invited');
                el.data('checked',1);
                model.set('checked',1);
            }
        }
    });


    return {
        ContactItem:ContactItem,
        ContactList:ContactList
    };
});