(function(window) {

    Number.prototype.isNumber = function ()
    { return (typeof value === "number" && isFinite(value)); };

    Number.prototype.toInt = function()
    {
        if (Number.isInteger(this) == true)
            return this;

        return intEx(this);
    };

    Number.prototype.toFloat = function()
    {
        if (Number(this) === this && this % 1 !== 0)
            return this;
        return floatEx(this);
    };

})(window);
