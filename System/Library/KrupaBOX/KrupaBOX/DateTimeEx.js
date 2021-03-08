(function(window)
{
    window.DateTimeEx = function(date) {

        this.dateTime = null;

        this.constructor = function(date)
        {
            if (date instanceof DateTimeEx)
            { this.dateTime = date.dateTime; return null; }

            if (date instanceof Date)
            { this.dateTime = date; return null; }

            date = date.toString();
            date = date.replaceAll("/", "-");
            date = date.trim();

            var dateSplit = date.split(" ");
            if (dateSplit.count <= 1)
                date = (dateSplit + " 00:00");

            date = new Date(date);
            this.dateTime = date;
        };

        this.getYear = function(padding)
        {
            var year = this.dateTime.getYear();
            return year;
        };

        this.getMonth = function(padding)
        {
            var month = (this.dateTime.getMonth() + 1);
            if (padding == true) {
                if (month < 10)
                    return ("0" + month.toString());
                return month.toString();
            }
            return month;
        };


        this.getDay = function(padding)
        {
            var day = (this.dateTime.getDate() + 1);
            if (padding == true) {
                if (day < 10)
                    return ("0" + day.toString());
                return day.toString();
            }
            return day;
        };

        this.getHour = function(padding)
        {
            var hours = this.dateTime.getHours();
            if (padding == true) {
                if (hours < 10)
                    return ("0" + hours.toString());
                return hours.toString();
            }
            return hours;
        };

        this.getMinute = function(padding)
        {
            var minutes = this.dateTime.getMinutes();
            if (padding == true) {
                if (minutes < 10)
                    return ("0" + minutes.toString());
                return minutes.toString();
            }
            return minutes;
        };

        this.addDay = function(value)
        {
            value = toInt(value);
            this.dateTime.setDate(this.dateTime.getDate() + value);
            return this;
        };

        this.addMinute = function(value)
        {
            value = toInt(value);
            this.dateTime.setMinutes( this.dateTime.getMinutes() + value);
            return this;
        };

        this.addSecond = function(value)
        {
            value = toInt(value);
            this.dateTime.setSeconds( this.dateTime.getSeconds() + value);
            return this;
        };

        this.constructor(date);
        return this;
    };

    window.DateTimeEx.now = function()
    {
        var dateNow = Date.now();
        var dateTime = new Date(dateNow);

        return new DateTimeEx(dateTime);
    };

    window.DateTime = window.DateTimeEx;

})(window);
