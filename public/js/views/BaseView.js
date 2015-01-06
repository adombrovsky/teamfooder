define([
    'jquery',
    'backbone',
    'mustache',
], function($, Backbone, Mustache) {

    var ArrayStorage = function()
    {
        this.storage = {};
    };
    ArrayStorage.prototype.get = function(key)
    {
        return this.storage[key];
    };
    ArrayStorage.prototype.set = function(key, val)
    {
        return this.storage[key] = val;
    };
    return Backbone.View.extend({
        templateDriver: new ArrayStorage(),
        viewPath: '/views/',
        template: function () {
            var view, data, template, self;

            switch (arguments.length) {
                case 0:
                    view = this.view;
                    break;
                case 1:
                    view = this.view;
                    data = arguments[0];
                    break;
                case 2:
                    view = arguments[0];
                    data = arguments[1];
                    break;
            }

            template = this.getTemplate(view, false);
            self = this;

            return template(data, function (partial) {
                return self.getTemplate(partial, true);
            });
        },
        getTemplate: function (view, isPartial) {
            return this.templateDriver.get(view) || this.fetch(view, isPartial);
        },
        setTemplate: function (name, template) {
            return this.templateDriver.set(name, template);
        },
        fetch: function (view, isPartial) {
            var markup = $.ajax({
                async: false,
                //the URL of our template, we can optionally use dot notation
                url: this.viewPath + view.split('.').join('/') + '.mustache'
            }).responseText;

            return isPartial
                ? markup
                : this.setTemplate(view, Mustache.compile(markup));
        }
    });

});