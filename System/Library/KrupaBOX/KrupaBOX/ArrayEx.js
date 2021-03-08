(function(window) {

    window.Arr = function(value)
    {
        var type = typeOf(value);

        if (type == "array")
            return value;
        else if (type == "object")
        {
            var objectToParse = value;
            var arrParse = [];

            for( var i in objectToParse )
            {
                if (!objectToParse.hasOwnProperty(i))
                    continue;

                var _value = objectToParse[i];
                if (_value instanceof Object)
                    _value = Arr(_value);

                //if (Number.isNumber(i))
                    arrParse[i] = _value;
                //else arrParse.push(_value);
            }

            return arrParse;
        }
        else if (type == "collection")
        {
            var arr = [];
            for(var i = 0; i < value.length; i++) arr.push(value[i]);
            return Arr(arr);
        }
        else if (value === null || value === undefined)
            return [];
        else return [value];
    };

    Array.prototype.add = function (value, canDuplicate)
    {
        if (canDuplicate === null || canDuplicate === undefined) canDuplicate = true;
        if (canDuplicate == false && this.contains(value))
            return this;
        this.push(value);
        return this;
    };

    Array.prototype.addKey = function(key, value)
    {
        this[key] = value;
        return this;
    };

    Array.prototype.contains = function(value)
    {
        var index = this.indexOf(value);
        return (index > 0 || index === 0);
    };

    Array.prototype.containsKey = function (value, ignoreLength)
    {
        if (ignoreLength === null || ignoreLength === undefined) ignoreLength = true;
        if (ignoreLength == true && string(value).toString().toLower() == "length")
            return false;

        return this.hasOwnProperty(value);
    };

    Array.prototype.removeKey = function (value, ignoreLength)
    {
        if (this.containsKey(value))
        {
            this[value] = undefined;
            delete this[value];
        }
    };

    Array.prototype.shuffle = function()
    { shuffle(this); return this; };

    Array.prototype.reverse = function()
    { return array_reverse(this, true); };

    Array.prototype.toArr = function (value, ignoreLength)
    { return this; };

    Object.defineProperty(Array.prototype, "count", {
        get : function() { return this.length; }
    });

    Array.prototype.toObject = function()
    {
        var obj = {};

        for (var key in this)
        {
            if (!this.hasOwnProperty(key)) continue;

            if (typeof this[key] != "string" && this[key] instanceof Array)
                obj[key] = this[key].toObject();
            else obj[key] = this[key];
        }

        return obj;
    };

})(window);
