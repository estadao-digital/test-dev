(function(window) {

    window.Geolocation = {};

    Geolocation.getCurrent = function(delegate)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;
        if (window.navigator == null || window.navigator == undefined || window.navigator.geolocation == null || window.navigator.geolocation == undefined) {
            var data = Arr();
            data.error = "BROWSER_DONT_SUPPORT_GEOLOCATION";
            delegate(data, false);
            return null;
        }

        window.navigator.geolocation.getCurrentPosition(
            function(location)
            {
                if (location.coords != null && location.coords != undefined)
                {
                    var data = Arr();
                    data.latitude  = floatEx(location.coords.latitude).toFloat();
                    data.longitude = floatEx(location.coords.longitude).toFloat();
                    delegate(data, true);
                    return null;
                }

                var data = Arr();
                data.error = "INTERNAL_SERVER_ERROR";
                delegate(data, false);
                return null;
            },
            function(error) {
                if (error.code == 1)
                {
                    var error = "PERMISSION_DENIED";
                    var protocol = Connection.getProtocol();
                    if (protocol != "https")
                        error = "PROTOCOL_NOT_HTTPS";
                    var data = Arr();
                    data.error = error;
                    delegate(data, false);
                    return null;
                }
        });

        return null;
    };

})(window);
