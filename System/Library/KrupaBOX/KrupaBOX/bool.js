(function(window) {

    window.Bool = function(value)
    {
        return value;
    };

    window.bool = Bool;
    window.boolEx = Bool;

    window.toBool = function(value) { return boolEx(value).toBool(); }

})(window);
