(function(window) {
    window.Time = function(value)
    {
        this.value = null;

        this.constructor = function(value)
        { this.value = floatEx(value).toFloat(); };

        this.get = function() {
            return this.value;
        };

        this.constructor(value);
        return this;
    };

    Time.now = function(returnNumber)
    {
        returnNumber = ((returnNumber === true));
        var timeFloat = (new Date()).getTime();
        timeFloat = (timeFloat / 1000);

        var time = new Time(timeFloat);
        if (returnNumber == true)
            return time.get();
        return time;
    };

    Time.sleep = function(seconds)
    {
        seconds = toFloat(seconds);
        if (seconds <= 0)
            return null;

        var endTime = (Time.now(true) + seconds);
        while (Time.now(true) < endTime) {}
        return null;
    };

})(window);
