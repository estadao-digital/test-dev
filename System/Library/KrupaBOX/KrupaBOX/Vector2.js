(function(window) {
    window.Vector2 = function(x, y)
    {
        this.x = null;
        this.y = null;

        this.constructor = function(x, y)
        {
            this.x = floatEx(x).toFloat();
            this.y = floatEx(y).toFloat();
        };

        this.constructor(x, y);
        return this;
    };

    Vector2.zero = function()
    { return new Vector2(0, 0); };

    Vector2.one = function()
    { return new Vector2(1, 1); };

})(window);
