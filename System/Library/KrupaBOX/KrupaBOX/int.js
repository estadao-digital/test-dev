(function(window) {

    window.Int = function(value)
    {
        if (value === true || value === false)
           return ((value === true) ? 1 : 0);

        value = String(value).toLower();
        value = parseInt(value);
        if (isNaN(value)) return 0;

        return value;
    };

    window.int = Int;
    window.intEx = Int;

    window.toInt = function(value) { return intEx(value).toInt(); }
})(window);

