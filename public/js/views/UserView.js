define([
    'jquery',
    'backbone',
    'views/BaseView',
], function($, Backbone, BaseView) {

    var UserDetails = BaseView.extend({
        view:'users.view',
        render:function()
        {
            var self = this;
            self.$el.html(this.template({
                user:this.model.attributes
            }));
        }
    });

    var UserItem = BaseView.extend({
        view:'users._user',
        render:function()
        {
            this.$el.html(this.template(this.model.attributes));
            return this;
        }
    });

    var UserList = BaseView.extend({
        view:'users.index',
        initialize: function(options)
        {
            this.options = options;
            this.perPage = this.options.perPage || 150;
            this.page = this.options.page || 0;
            this.fetching = this.collection.fetch();

//            if (this.options.infiniteScroll) this.enableInfiniteScroll();
        },
        render:function()
        {
            var self = this;
            this.fetching.done(function(){
                self.$el.html('');
                self.addUsers();
//                if (self.options.infiniteScroll) self.enableInfiniteScroll();
            });
        },
        paginate: function()
        {
            var users;
            users = this.collection.rest(this.perPage*this.page);
            users = _.first(users,this.perPage);
            this.page ++;
            return users;
        },
        addUsers: function()
        {
            var users = this.paginate();
            for(var i=0;i<users.length;i++)
            {
                this.addOneUser(users[i]);
            }
        },
        addOneUser:function(model)
        {
            var view = new UserItem({model:model});
            this.$el.append(view.render().el);
        },
        showUser: function(id)
        {
            var self = this;
//            this.disableInfiniteScroll();
            this.fetching.done(function(){
                var model = self.collection.get(id);
                if (!self.userView)
                {
                    self.userView = new self.options.userView({
                        el:self.el
                    })
                }

                self.userView.model = model;
                self.userView.render();
            });
        },
        /*infiniteScroll: function()
        {
            if($(window).scrollTop() >= $(document).height() - $(window).height() - 50)
            {
                this.addUsers();
            }
        },
        enableInfiniteScroll: function()
        {
            var self = this;

            $(window).on('scroll', function()
            {
                self.infiniteScroll();
            });
        },
        disableInfiniteScroll: function()
        {
            $(window).off('scroll');
        }*/
    });


    return {
        UserDetails:UserDetails,
        UserItem:UserItem,
        UserList:UserList
    };
});