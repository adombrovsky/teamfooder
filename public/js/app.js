require.config({
    baseUrl: "/js/",
    paths: {
        jquery          : 'libs/jquery.min',
        moment          : 'libs/node_modules/moment/moment',
        bootstrap       : 'libs/bootstrap',
        underscore      : 'libs/node_modules/underscore/underscore',
        backbone        : 'libs/node_modules/backbone/backbone',
        mustache        : 'libs/node_modules/mustache/mustache',
        datetimepicker  : 'libs/bootstrap-datetimepicker',
        tagsinput       : 'libs/bootstrap-tagsinput',
        chosen          : 'libs/node_modules/chosen-jquery-browserify/index'
    },
    shim: {
        underscore: {
            exports: "_"
        },
        backbone: {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        datetimepicker  : {
            deps: ['jquery', 'bootstrap', 'moment']
        },
        tagsinput  : {
            deps: ['jquery', 'bootstrap']
        },
        chosen  : {
            deps: ['jquery']
        }
    }
});

require([
    'jquery',
    'backbone',
    'views/BaseView',
    'views/NotificationView',
    'views/LoginView',
    'views/RegistrationView',
    'views/OrderView',
    'views/UserOrderView',
    'models/UserModel',
    'models/LoginModel',
    'models/NotificationModel',
    'models/OrderModel',
    'models/UserOrdersModel'
], function($, Backbone, BaseView, NotificationView, LoginView, RegistrationView, OrderView, UserOrderView, UserModel, LoginModel, NotificationModel, OrderModel, UserOrdersModel) {

    var AppRouter = Backbone.Router.extend({
        routes:
        {
                "":"index",
            "login":"login",
            "registration":"registration",
            "orders/create":"createOrder",
            "orders/view/:id" :"viewOrder",
            "orders/summary/:id" :"summaryOrder",
            "orders/edit/:id" :"editOrder",
            "orders/view/:id/edit/:userId" :"editUserOrder",
            "orders":"orderList"
        },
        initialize: function(options)
        {
            this.userData = {};
            this.userIsLogged = false;
            this.orderModule = options.orderModule;
            this.LoginView = options.LoginView;
            this.RegistrationView = options.RegistrationView;
            this.checkAuth();
        },
        checkAuth:function()
        {
            if (typeof window.loggedUser === 'object')
            {
                this.userData = window.loggedUser;
                this.userIsLogged = true;
            }
        },
        index:function()
        {
            var href = '/login';
            if (this.userIsLogged)
            {
                href = '/orders';
            }
            Backbone.history.navigate(href, true);
        },
        login:function()
        {
            this.LoginView.render();
        },
        registration:function()
        {
            this.RegistrationView.render();
        },
        orderList:function()
        {
            this.orderModule.page = 0;
            this.orderModule.loadData();
            this.orderModule.render();
        },
        createOrder:function()
        {
            this.orderModule.createOrder(new OrderModel.OrderModel());
        },
        viewOrder:function(id)
        {
            this.orderModule.viewOrder(id);
        },
        editOrder:function(id)
        {
            this.orderModule.editOrder(id);
        },
        editUserOrder:function(id, userId)
        {
            var userModel = new UserModel.UserModel({id:userId});
            var fetching = userModel.fetch();
            var self = this;
            fetching.done(function(){
                var UserOrdersList = new UserOrderView.UserOrdersList({
                    el             : $('[data-role="main"]'),
                    orderId        : id,
                    onlyRead       : (self.userData.id !== userModel.get('id')),
                    userInfo       : userModel.attributes,
                    collection     : new UserOrdersModel.UserOrdersCollection({url:'/dev/userorders/byUserRequest/'+id+'/'+userModel.get('id')})
                });

                UserOrdersList.render();
            });
        },
        summaryOrder:function(orderId)
        {
            this.orderModule.showOrderSummary(orderId);
        }
    });

    var notificationView = new NotificationView();

    $.ajaxSetup({
        statusCode: {
            400: function()
            {
                NotificationModel.notificationCollection.add({
                    type: 'danger', //danger, success, info, null
                    message: '<strong>Validation errors.</strong> Please enter correct data'
                });
            },
            401: function()
            {
                NotificationModel.notificationCollection.add({
                    type: 'info', //danger, success, info, null
                    message: 'Please create new account or login with existing one'
                });
            },
            403: function()
            {
                NotificationModel.notificationCollection.add({
                    type: 'danger', //danger, success, info, null
                    message: 'You do not have permission to do that'
                });
            },
            404: function()
            {
                NotificationModel.notificationCollection.add({
                    type: 'danger', //danger, success, info, null
                    message: 'Page Not Found'
                });
            },
            500: function()
            {
                NotificationModel.notificationCollection.add({
                    type: 'danger', //danger, success, info, null
                    message: 'The server encountered an error'
                });
            }
        }
    });

    $(document).on("click", "a[href]:not([data-bypass])", function(e){
        e.preventDefault();
        e.stopPropagation();

        var href = $(this).attr("href");
        Backbone.history.navigate(href, true);
    });

    $(document).on("click", "[data-toggle='view']", function(e)
    {
        e.preventDefault();
        e.stopPropagation();

        var self = $(this);
        var href = self.attr('data-target') || self.attr('href');

        Backbone.history.navigate(href, true);
    });


    var OrderList = new OrderView.OrderList({
        el             : $('[data-role="main"]'),
        collection     : new OrderModel.OrderCollection(),
        //orderView       : OrderView.OrderDetails,
        perPage        : 20,
        page           : 0,
        infiniteScroll : true
    });

    var router = new AppRouter({
        orderModule:OrderList,
        LoginView: new LoginView.LoginView({el:$('[data-role="main"]'),model:new LoginModel.LoginModel()}),
        RegistrationView: new RegistrationView.RegistrationView({el:$('[data-role="main"]'),model:new UserModel.UserModel()})
    });

    if (typeof window.silentRouter === 'undefined') window.silentRouter = false;

    Backbone.history.start({ pushState: true, root: '/', silent: window.silentRouter });
});