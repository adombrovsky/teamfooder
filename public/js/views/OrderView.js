define([
    'jquery',
    'backbone',
    'moment',
    'views/BaseView',
    'models/UserOrdersModel',
    'models/OrderModel',
    'models/RestaurantModel',
    'models/ContactModel',
    'views/UserOrderView',
    'views/ContactView',
    'datetimepicker',
], function($, Backbone, moment, BaseView, UserOrdersModel, OrderModel, RestaurantModel, ContactModel, UserOrderView, ContactView) {

    var $window, $document;

    $window   = $(window);
    $document = $(document);

    var OrderDetails = BaseView.extend({
        view:'orders.view',
        initialize: function(options)
        {
            this.options = options;
        },
        render:function()
        {
            var self = this;
            var date = moment.unix(this.model.get('date'));
            self.model.set('parserDate',date.format("dddd, MMMM Do YYYY, HH:mm"));
            self.$el.html(self.template({
                order:self.model.attributes
            }));

            return this;
        }
    });

    var OrderSummary = BaseView.extend({
        view:'orders.summary',
        orderId:null,
        events:{
            "click #finish-request":"finishRequest"
        },
        initialize: function(options)
        {
            this.options = options;
            var self = this;
            self.orderId = options.orderId;
            this.fetching = this.collection.fetch();

        },
        render:function()
        {
            var self = this;
            this.fetching.done(function(){
                var data = self.parseMealsList();
                self.$el.html(self.template({
                    order:self.model.attributes,
                    mealList:data.meal,
                    usersList:data.users
                }));
            });

            return this;
        },
        parseMealsList:function()
        {
            var meals = this.collection;
            var usersList = {};
            var mealList = {};
            for(var i = 0; i < meals.length;i++)
            {
                var currentMeal = meals.at(i);
                if (_.isUndefined(usersList[currentMeal.get('user_id')]))
                {
                    usersList[currentMeal.get('user_id')] = {
                        name:currentMeal.get('user').name,
                        cost:0
                    };
                }
                if (_.isUndefined(mealList[currentMeal.get('meal_id')]))
                {
                    mealList[currentMeal.get('meal_id')] = {
                        name:currentMeal.get('meal').title,
                        imageUrl:currentMeal.get('meal').imageUrl,
                        price:parseFloat(currentMeal.get('meal').price),
                        count:0,
                        cost:0
                    };
                }
                mealList[currentMeal.get('meal_id')].count += parseInt(currentMeal.get('count'));
                mealList[currentMeal.get('meal_id')].cost  += parseFloat((parseInt(currentMeal.get('count')) * mealList[currentMeal.get('meal_id')].price).toFixed(2));
                usersList[currentMeal.get('user_id')].cost += parseFloat((parseInt(currentMeal.get('count')) * mealList[currentMeal.get('meal_id')].price).toFixed(2));
            }
            return {users: _.values(usersList),meal: _.values(mealList)};
        },
        finishRequest:function()
        {
            var userDataObject = window.loggedUser;
            var model = this.model;
            if (parseInt(model.get('user_id')) !== parseInt(userDataObject.id)) return;
            model.save({id:model.get('id'),userId:userDataObject.id},{
                url:'/dev/orders/finish',
                success:function(){
                    Backbone.history.navigate('/orders', true);
                },
                patch:true
            });
        }
    });

    var OrderForm = BaseView.extend({
        view:'orders._form',
        events:{
            "click #create_request_button":'createNewRequest'
        },
        initialize: function(options)
        {
            this.options = options;
            var self = this;
            self.orderId = options.orderId;
            self.restaurants = new RestaurantModel.RestaurantCollection();
            this.fetching = self.restaurants.fetch();
        },
        render:function()
        {
            var self = this;
            this.fetching.done(function () {
                if (!self.model.isNew())
                {
                    var date = moment.unix(self.model.get('date'));
                    self.model.set('parserDate',date.format("DD-MM-YYYY HH:mm"));
                }
                self.$el.html(self.template({model:self.model.attributes,restaurants:self.restaurants.toJSON()}));
                self.$el.find(".google-import").data('href',window.loginUrl.google);
                self.$el.find(".google-import").on('click', function () {
                    var t = $(this);
                    var url = t.data('href');
                    var win = window.open(url, "login window", 'width=800, height=600');
                    var pollTimer = window.setInterval(function () {
                        try {
                            if (win.document.URL.indexOf('callback') != -1) {
                                window.clearInterval(pollTimer);
                                win.close();
                                self.contactView = new ContactView.ContactList({collection:new ContactModel.ContactCollection()});
                                self.contactView.render();
                            }
                        } catch (e) {
                        }
                    }, 500)
                });

                self.$el.find('#datetimepicker1').datetimepicker({
                    minDate:new Date(),
                    format:'DD-MM-YYYY HH:mm',
                    minuteStepping:5
                });

                $("#chosen").chosen({
                    width:'200px'
                });
            });
            return this;
        },
        createNewRequest:function(e)
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

            if (self.contactView)
            {
                self.model.set('emails',self.contactView.collection.where({checked:1}));
            }
            self.model.save(self.model.attributes,{
                success:function()
                {
                    Backbone.history.navigate('/orders', true);
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

    var OrderItem = BaseView.extend({
        view:'orders._order',
        tagName:'tr',
        initialize: function(options)
        {
            this.options = options;
            this.listenTo(this.model, 'change:status', this.render);
        },
        render:function()
        {
            var date = moment.unix(this.model.get('date'));
            this.model.set('parserDate',date.format("dddd, MMMM Do YYYY, HH:mm"));
            this.model.set('usersCount',this.model.get('users').length);

            var userDataObject = window.loggedUser;

            this.model.set('is_owner',(this.model.get('user_id') == userDataObject.id));
            this.model.set('hideManageButtons',(this.model.get('status') >= 1 || this.model.get('is_owner') != 1));

            this.$el.html(this.template(this.model.attributes));
            switch (parseInt(this.model.get('status')))
            {
                case 1:
                    this.$el.addClass('success');
                    break;
                case 2:
                    this.$el.addClass('warning');
                    break;
                case 3:
                    this.$el.addClass('danger');
                    break;
                case 0:
                default :
                    break;
            }
            return this;
        }
    });

    var OrderList = BaseView.extend({
        view:'orders.index',
        events:{
            "click .complete_order_status":"updateStatusComplete",
            "click .deny_order_status":"updateStatusDeny"
        },
        initialize: function(options)
        {
            this.options = options;
            this.perPage = this.options.perPage || 150;
            this.loadData();
            if(this.options.infiniteScroll) this.enableInfiniteScroll();
        },
        loadData:function()
        {
            this.fetching = this.collection.fetch();
        },
        render:function()
        {
            var self = this;
            var html=this.template(this.collection.toJSON());
            this.$table=$(html);
            this.fetching.done(function(){
                self.$el.html('');
                self.addOrders();
                self.$el.append(self.$table);
                if(self.options.infiniteScroll) self.enableInfiniteScroll();
            });
        },
        infiniteScroll: function()
        {
            if($window.scrollTop() >= $document.height() - $window.height() - 50)
            {
                this.addOrders();
            }
        },
        enableInfiniteScroll: function()
        {
            var self = this;

            $window.on('scroll', function()
            {
                self.infiniteScroll();
            });
        },
        disableInfiniteScroll: function()
        {
            $window.off('scroll');
        },
        paginate: function()
        {
            var orders;
            orders = this.collection.rest(this.perPage*this.page);
            orders = _.first(orders,this.perPage);
            this.page ++;
            return orders;
        },
        addOrders: function()
        {
            var orders = this.paginate();
            for(var i=0;i<orders.length;i++)
            {
                this.addOneOrder(orders[i]);
            }
        },
        addOneOrder:function(model)
        {
            var view = new OrderItem({model:model});
            this.$table.append(view.render().el);
        },
        createOrder:function(model)
        {
            this.disableInfiniteScroll();
            var view = new OrderForm({model:model});
            this.$el.html(view.render().el);
        },
        viewOrder: function(id)
        {
            this.disableInfiniteScroll();
            var self = this;
            var model = new OrderModel.OrderModel({id:id});
            var fetching = model.fetch();
            fetching.done(function(){
                var orderDetails = new OrderDetails({
                    el:self.el,
                    model:model
                });

                orderDetails.render();

                var userOrderView = new UserOrderView.UsersList({
                    orderId:id,
                    collection: new OrderModel.OrderUsersCollection({url:'/dev/orders/'+id+'/getUsers'}),
                    $el:$("#userList")
                });
                userOrderView.render();
            });
        },
        editOrder: function(id)
        {
            this.disableInfiniteScroll();
            var self = this;
            var model = new OrderModel.OrderModel({id:id});
            var fetching = model.fetch();
            fetching.done(function(){
                var view = new OrderForm({model:model});
                self.$el.html(view.render().el);
            });
        },
        updateStatusDeny:function(e)
        {
            var el = $(e.target);
            var userDataObject = window.loggedUser;
            var model = this.collection.get(el.data('id'));
            if (parseInt(model.get('user_id')) !== parseInt(userDataObject.id)) return;

            model.save({id:model.get('id'),userId:userDataObject.id},{
                url:'/dev/orders/cancel',
                success:function(model){
                    model.set('statusName','Denied');
                    model.set('status',3);
                },
                patch:true
            });
        },
        showOrderSummary:function(id)
        {
            this.disableInfiniteScroll();
            var self = this;
            var model = new OrderModel.OrderModel({id:id});
            var fetching = model.fetch();
            fetching.done(function(){
                var view = new OrderSummary({model:model, collection:new UserOrdersModel.UserOrdersCollection({url:'/dev/userorders/byRequest/'+id})});
                self.$el.html(view.render().el);
            });
        }
    });


    return {
        OrderDetails:OrderDetails,
        OrderItem:OrderItem,
        OrderList:OrderList,
        OrderSummary:OrderSummary
    };
});