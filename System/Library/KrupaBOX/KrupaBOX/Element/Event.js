(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.Event = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.Event.prototype.onClick = function(delegate)
    {
        if (typeof (delegate) !== 'function') return null;
        if (this.elementEx.element == null)   return null;

        this.elementEx.jQueryKB.click(function(event)
        {
            event.preventDefault();
            var target = window.jQueryKB(event.target);
            var data = Arr();
            data.target = (target.length > 0) ? (new ElementEx(target[0])) : null;
            data.preventDefault = event.preventDefault;
            delegate(data);
        })
    };

    ElementEx.Event.prototype.onChange = function(delegate)
    {
        if (typeof (delegate) !== 'function') return null;
        if (this.elementEx.element == null)   return null;

        this.elementEx.jQueryKB.change(function(event)
        {
            event.preventDefault();
            var target = window.jQueryKB(event.target);
            var data = Arr();
            data.target = (target.length > 0) ? (new ElementEx(target[0])) : null;
            data.preventDefault = event.preventDefault;
            delegate(data);
        })
    };

    ElementEx.Event.prototype.onInput = function(delegate)
    {
        if (typeof (delegate) !== 'function') return null;
        if (this.elementEx.element == null)   return null;

        this.elementEx.jQueryKB.bind('input', function(event)
        {
            event.preventDefault();
            var target = window.jQueryKB(event.target);
            var data = Arr();
            data.target = (target.length > 0) ? (new ElementEx(target[0])) : null;
            data.preventDefault = event.preventDefault;
            delegate(data);
        });
    };

})(window);
