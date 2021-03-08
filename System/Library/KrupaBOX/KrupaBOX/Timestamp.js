(function(window) {
    window.Timestamp = function(value)
    {
        this.value = null;

        this.constructor = function(value)
        { this.value = intEx(value).toInt(); };

        this.get = function() {
            return this.value;
        };

        this.constructor(value);
        return this;
    };

    Timestamp.now = function(returnNumber)
    {
        returnNumber = ((returnNumber === true));
        var timestamp = new Timestamp(Time.now(returnNumber));
        if (returnNumber == true)
            return timestamp.get();
        return timestamp;
    };

})(window);
