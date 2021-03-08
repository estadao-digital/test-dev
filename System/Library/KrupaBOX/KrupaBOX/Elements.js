(function(window) {

    window.Elements = function() {
        this.elements = Arr();

        this.constructor = function() {};

        this.add = function(element)
        { return this.elements.add(element); };

        this.constructor();
        return this;
    };

    Elements.find = function(searchQuery)
    {
        searchQuery = String(searchQuery).toString();
        var found = window.jQueryKB(searchQuery);

        if (found.length <= 0) return null;

        var elements = new Elements();
        for (var i = 0; i < found.length; i++)
            elements.add(new ElementEx(found[i]));

        return elements;
    };

    Elements.prototype.isEmpty = function()
    { return (this.elements.length <= 0); };

    // Elements.implement("find", function(searchQuery, multiple)
    // {
    //     searchQuery = String.from(searchQuery);
    //     var found = this.getElements(searchQuery);
    //
    //     if (multiple == true) return found;
    //     return (found.length > 0) ? found[0] : null;
    // });

    Elements.prototype.onClick = function(delegate)
    {
        if (typeof (delegate) !== 'function')
            return null;

        for (var key in this.elements)
            if (this.elements.hasOwnProperty(key))
                this.elements[key].onClick(delegate);
    };

    Elements.prototype.onChange = function(delegate)
    {
        if (typeof (delegate) !== 'function')
            return null;

        for (var key in this.elements)
            if (this.elements.hasOwnProperty(key))
                this.elements[key].onChange(delegate);
    };

    Elements.prototype.onInput = function(delegate)
    {
        if (typeof (delegate) !== 'function')
            return null;
        
        for (var key in this.elements)
            if (this.elements.hasOwnProperty(key))
                this.elements[key].onInput(delegate);
    };

})(window);
