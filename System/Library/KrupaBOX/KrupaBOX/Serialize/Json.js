(function(window)
{
    window.Serialize = window.Serialize || {};
    Serialize.Json = {};

    Serialize.Json.decode = function(value)
    { return Arr(JSON.parse(value)); };

    Serialize.Json.encode = function(value)
    {
        if (value instanceof Array);
            value = Arr(value).toObject();

        return JSON.stringify(value);
    }

})(window);
