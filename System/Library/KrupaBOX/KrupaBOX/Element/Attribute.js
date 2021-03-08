(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.Attribute = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; this.__defineProperties__(); };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.Attribute.prototype.set = function (attribute, value)
    {
        if (this.elementEx.element == null) return null;
        attribute = String(attribute).toString();
        this.elementEx.jQueryKB.attr(attribute, value);
    };

    ElementEx.Attribute.prototype.add = function (attribute, value)
    { return this.set(attribute, value); };

    ElementEx.Attribute.prototype.get = function (attribute)
    {
        if (this.elementEx.element == null) return null;
        attribute = String(attribute).toString();
        return this.elementEx.jQueryKB.attr(attribute);
    };

    ElementEx.Attribute.prototype.remove = function (attribute)
    {
        if (this.elementEx.element == null) return null;
        attribute = String(attribute).toString();
        this.elementEx.jQueryKB.attr(attribute, null);
    };

    ElementEx.Attribute.prototype.contains = function (attribute)
    {
        if (this.elementEx.element == null) return null;
        attribute = String(attribute).toString();
        return this.elementEx.jQueryKB.attr(attribute);
    };

    ElementEx.Attribute.prototype.getAttributes = function ()
    {
        if (this.elementEx.element == null) return null;

        var attributes = this.elementEx.element.attributes;
        var cleanAttributes = Arr();

        for (var i = 0; i < attributes.length; i++)
            if (attributes[i].name != null && attributes[i].name != "")
                cleanAttributes[attributes[i].name] = this.get(attributes[i].name);

        return cleanAttributes;
    };

    ElementEx.Attribute.prototype.getList = function ()
    { return this.getAttributes(); };

    ElementEx.Attribute.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "attributes", {
            get: function () { return this.getAttributes(); }
        });
    };

})(window);
