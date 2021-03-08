(function(window) {

    window.Float = function(value)
    {
        value = String(value);
        value = parseFloat(value);

        var precision = (value.toPrecision(15));
        value = parseFloat(precision);

        if (isNaN(value)) return toFloat(0);

        return value;
    };

    window.float = Float;
    window.floatEx = Float;

    window.toFloat = function(value) { return floatEx(value).toFloat(); };

})(window);
