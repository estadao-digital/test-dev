(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.Scroll = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; this.__defineProperties__(); };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.Scroll.prototype.toElement = function (element, miliseconds)
    {
        if (this.elementEx.element == null) return null;

        var toElement = Element.find(element);
        if (toElement.element == null) return null;

        if (miliseconds == null || miliseconds == undefined)
            miliseconds = 1;

        miliseconds = miliseconds.toInt();
        if (miliseconds <= 0) miliseconds = 1;

        this.elementEx.jQueryKB.animate({
            scrollTop: toInt(toElement.jQueryKB.offset().top)
        }, miliseconds);
    };

    ElementEx.Scroll.prototype.toPixel = function (pixel, miliseconds)
    {
        if (this.elementEx.element == null) return null;

        if (pixel == null || pixel == undefined)
            pixel = 0;

        pixel = pixel.toInt();

        if (miliseconds == null || miliseconds == undefined)
            miliseconds = 1;

        miliseconds = miliseconds.toInt();
        if (miliseconds <= 0) miliseconds = 1;

        this.elementEx.jQueryKB.animate({
            scrollTop: pixel
        }, miliseconds);
    };

    ElementEx.Scroll.prototype.get = function (key)
    {
        if (this.elementEx.element == null) return null;
        key = String(key).toString();
        key = key.toLowerCase();

        if (key == "width")
            return (this.elementEx.jQueryKB.prop("scrollWidth"));
        else if (key == "height")
            return (this.elementEx.jQueryKB.prop("scrollHeight"));
    };

    ElementEx.Scroll.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "width", {
            get: function () { return this.get("width"); }
        });

        Object.defineProperty(this, "height", {
            get: function () { return this.get("height"); }
        });
    };

})(window);
