(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.ClassEx = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; this.__defineProperties__(); };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.ClassEx.prototype.add = function (_class)
    {
        if (this.elementEx.element == null) return null;
        _class = String(_class).toString();
        this.elementEx.jQueryKB.addClass(_class);
    };

    ElementEx.ClassEx.prototype.remove = function (_class)
    {
        if (this.elementEx.element == null) return null;
        _class = String(_class).toString();
        this.elementEx.jQueryKB.removeClass(_class);
    };

    ElementEx.ClassEx.prototype.contains = function (_class)
    {
        if (this.elementEx.element == null) return null;
        _class = String(_class).toString();
        return this.elementEx.jQueryKB.hasClass(_class);
    };

    ElementEx.ClassEx.prototype.getClasses = function ()
    {
        if (this.elementEx.element == null) return null;

        var classes =  this.elementEx.jQueryKB.attr("class");
        if (classes == null) return Arr();
        return Arr(classes.split(" "));
    };

    ElementEx.ClassEx.prototype.getList = function ()
    { return this.getClasses(); };

    ElementEx.ClassEx.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "classes", {
            get: function () { return this.getClasses(); }
        });
    };

})(window);
