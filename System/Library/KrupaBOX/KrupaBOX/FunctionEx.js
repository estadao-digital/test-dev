(function(window) {

    window.FunctionEx = {};

    FunctionEx.isFunction = function(obj) {
        return !!(obj && obj.constructor && obj.call && obj.apply);
    };

    FunctionEx.delay = function(delegate, delay, params)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        delay = toFloat(delay);
        if (delay <= 0) delay = 1;

        return new FunctionEx.Delay(delegate, delay, params);
    };

    FunctionEx.interval = function(delegate, delay, params)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        delay = toFloat(delay);
        if (delay <= 0) delay = 1;

        return new FunctionEx.Interval(delegate, delay, params);
    };

})(window);
