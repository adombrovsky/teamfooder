define([
    'jquery',
    'backbone',
    'underscore',
    'views/BaseView',
    'models/UserOrdersModel',
    'models/MealModel',
    'chosen',
], function($, Backbone, underscore, BaseView, UserOrdersModel, MealModel) {

    var UserOrdersItem = BaseView.extend({
        view:'user_orders._item',
        tagName:'tr',
        render:function()
        {
            this.$el.html(this.template(this.model.attributes));
            return this;
        }
    });

    var UserListTable = BaseView.extend({
        view:'user_orders._table',
        tagName:'table',
        id:'userListTable',
        className:'table table-bordered',
        initialize:function(options)
        {
            this.options = options;
            this.collection = options.collection;
        },
        render:function()
        {
            this.$el.html(this.template({users:this.collection}));
            return this;
        }
    });

    var UsersList = BaseView.extend({
        events:{
            "click .remove-request":"removeUserOrder"
        },
        initialize: function(options)
        {
            this.options = options;
            this.orderId = options.orderId;
            this.perPage = this.options.perPage || 150;
            this.page = this.options.page || 0;
            this.$el = options.$el;
            this.fetching = this.collection.fetch();
        },
        render:function()
        {
            var self = this;
            this.fetching.done(function(){
                self.listenTo(self.collection, 'remove', self.updateUsersList);
                self.addUsers();
            });
            return this;
        },
        updateUsersList:function()
        {
            this.page = 0;
            this.addUsers();
        },
        paginate: function()
        {
            var users;
            users = this.collection.rest(this.perPage*this.page);
            users = _.first(users,this.perPage);
            this.page ++;
            return users;
        },
        addUsers:function()
        {
            this.usersList = [];
            var users = this.paginate();
            for(var i=0;i<users.length;i++)
            {
                this.addOneUser(users[i]);
            }

            var tableView = new UserListTable({collection:this.usersList});
            this.$el.html(tableView.render().el);
        },
        addOneUser:function(model)
        {
            var userDataObject = window.loggedUser;
            model.set('is_owner',(userDataObject.id === model.get('user').id));
            model.set('orderId',this.orderId);
            model.set('id', _.uniqueId(''));
            this.usersList.push(model.attributes);
        },
        removeUserOrder:function(e)
        {
            var el = $(e.target);
            var self = this;
            var model = _.find(self.collection.models, function(obj) {
                return typeof _.findWhere([obj.get('user')], {id: el.data('userId')}) !== 'undefined';
            });
            if (model)
            {
                model.destroy({url:'/dev/userorders/removeByUser/'+model.get('orderId')+'/'+model.get('user').id,success:function(){/*self.collection.remove(model)*/}});
            }
        }
    });

    var UserOrdersList = BaseView.extend({
        orderId: null,
        onlyRead:true,
        view:'user_orders.index',
        events:{
            'click #add_meal':"addMeal",
            'click .update_amount':"updateAmount",
            'click .remove_meal':"removeMeal"
        },
        initialize: function(options)
        {
            this.options = options;
            this.orderId = options.orderId;
            this.onlyRead = options.onlyRead;
            this.perPage = this.options.perPage || 150;
            this.page = this.options.page || 0;
            this.mealCollection = new MealModel.MealCollection({orderId:this.orderId});
            this.usersOrders = new UserOrdersModel.UserOrdersModel();
            this.usersOrders.set('userName',this.options.userInfo.name);
            this.usersOrders.set('orderId',this.orderId);
            this.listenTo(this.collection, 'add', this.renderTable);
            this.listenTo(this.collection, 'change', this.renderTable);
            this.listenTo(this.collection, 'destroy', this.renderTable);
            this.listenTo(this.collection, 'sync', this.renderTable);
        },
        render:function()
        {
            var self = this;
            $.when(this.collection.fetch(),this.mealCollection.fetch()).done(function () {
                self.renderTable();
            });
            return this;
        },
        renderTable:function()
        {
            this.addUserOrders();
            this.$el.html(this.template({model:this.usersOrders.attributes,mealList:this.mealCollection.toJSON(),onlyRead:this.onlyRead}));
            $("#chosen").chosen({
                width:'400px',
                template: function (text, templateData) {
                    return [
                        "<div style='float: left;'><img style='width:110px' src='"+templateData.image+"'/></div>" +
                        "<div style='float: right; width: 240px'><span style='float: right;'>Price: " + templateData.price + "</span>",
                        "<div><a target='_blank' data-bypass='1' href='"+templateData.href+"'>" + text + "</a></div>",
                        "<div style='font-weight: normal !important; font-size: 10px;'><i>" + templateData.description + "</i></div></div><div class='clearfix'></div>"
                    ].join("");
                }
            });
        },
        paginate: function()
        {
            var userOrders;
            userOrders = this.collection.rest(this.perPage*this.page);
            userOrders = _.first(userOrders,this.perPage);
//            this.page ++;
            return userOrders;
        },
        addUserOrders: function()
        {
            var userOrders = this.paginate();
            this.usersOrders.set('meal',[]);
            this.usersOrders.set('totalSum',0);
            this.usersOrders.set('totalCount',0);
            var parsedUserOrderList = {};
            for(var i=0;i<userOrders.length;i++)
            {
                var currentUserOrder = userOrders[i];
                if (typeof parsedUserOrderList[currentUserOrder.get('user_id')] === 'undefined')
                {
                    parsedUserOrderList[currentUserOrder.get('user_id')] = {
                        userName: currentUserOrder.get('user').name,
                        meals:{}
                    };
                }

                if (typeof parsedUserOrderList[currentUserOrder.get('user_id')]['meals'][currentUserOrder.get('meal_id')] !== 'undefined')
                {
                    parsedUserOrderList[currentUserOrder.get('user_id')]['meals'][currentUserOrder.get('meal_id')].count += parseInt(currentUserOrder.get('count'));
                    parsedUserOrderList[currentUserOrder.get('user_id')]['meals'][currentUserOrder.get('meal_id')].sum = (parseFloat(parsedUserOrderList[currentUserOrder.get('user_id')]['meals'][currentUserOrder.get('meal_id')].sum)+parseFloat(currentUserOrder.get('meal').price * parseInt(currentUserOrder.get('count')))).toFixed(2);
                }
                else
                {
                    parsedUserOrderList[currentUserOrder.get('user_id')]['meals'][currentUserOrder.get('meal_id')] = {
                        title: currentUserOrder.get('meal').title,
                        imageUrl: currentUserOrder.get('meal').imageUrl,
                        price: currentUserOrder.get('meal').price,
                        sum: (currentUserOrder.get('meal').price * parseInt(currentUserOrder.get('count'))).toFixed(2),
                        id: currentUserOrder.get('meal').id,
                        userOrderID:parseInt(currentUserOrder.get('id')),
                        count: parseInt(currentUserOrder.get('count'))
                    };
                }
                parsedUserOrderList[currentUserOrder.get('user_id')]['orderId'] = currentUserOrder.get('order_id');
            }

            for(var a in parsedUserOrderList)
            {
                if (parsedUserOrderList.hasOwnProperty(a))
                {
                    this.addOneUserOrder(parsedUserOrderList[a]);
                }
            }

        },
        addOneUserOrder:function(parsedUserOrderItem)
        {
            var meals = [];
            var totalSum = 0;
            var totalCount = 0;
            this.usersOrders.set('userName',parsedUserOrderItem.userName);
            for (var b in parsedUserOrderItem.meals)
            {
                if (parsedUserOrderItem.meals.hasOwnProperty(b))
                {
                    meals.push(parsedUserOrderItem.meals[b]);
                    totalSum += parseFloat(parsedUserOrderItem.meals[b].sum);
                    totalCount += parseFloat(parsedUserOrderItem.meals[b].count);
                }
            }
            meals[ meals.length - 1 ].last = true;
            this.usersOrders.set('meal',meals);
            this.usersOrders.set('totalSum',totalSum.toFixed(2));
            this.usersOrders.set('totalCount',totalCount);
        },
        addMeal:function(e)
        {
            var el = $(e.target).closest('.new-meal-block');
            var data = el.find("#chosen").find('option:selected').data();
            var self = this;
            var modelAttributes = {};
            var userDataObject = window.loggedUser;
            modelAttributes.user_id = userDataObject.id;

            modelAttributes.meal_id = data.id;
            modelAttributes.order_id = data.order_id;
            modelAttributes.count = el.find("#amount").val();
            var model = self.collection.findWhere({
                user_id:modelAttributes.user_id,
                meal_id:modelAttributes.meal_id,
                order_id:modelAttributes.order_id
            });
            if (!model)
            {
                model = new UserOrdersModel.UserOrdersModel(modelAttributes);
            }
            else
            {
                model.set('count',parseInt(model.get('count'))+parseInt(modelAttributes.count));
            }

            model.save(model.attributes,
                {
                    success:function(a,b,c,d,e)
                    {
                        self.collection.add(model.attributes);
                    }
                });
        },
        updateAmount:function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            var el = $(e.target);
            var data = el.data();
            var amount = data.amount;
            var model = this.collection.get(data.id);
            var self = this;
            model.set('count',parseInt(model.get('count'))+parseInt(amount));
            if (model.get('count') < 1)
            {
                model.destroy({success:function(){self.collection.remove(model)}});
            }
            else
            {
                model.save();
            }
        },
        removeMeal:function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            var el = $(e.target);
            var data = el.data();
            var model = this.collection.get(data.id);
            model.destroy();
        }
    });


    return {
        UserOrdersItem:UserOrdersItem,
        UserOrdersList:UserOrdersList,
        UsersList:UsersList
    };
});