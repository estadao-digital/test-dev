(function(window) {

    window.Input = (window.Input || {});
    Input.Video = {};

    Input.Video.getStream = function(delegate, facingMode)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        if (window.navigator !== null && window.navigator !== undefined)
            navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

        if (window.navigator == null || window.navigator === undefined || navigator.mediaDevices == null ||
            navigator.mediaDevices === undefined || navigator.mediaDevices.getUserMedia == null || navigator.mediaDevices.getUserMedia === undefined)
        {
            var data = Arr();
            data.error = "BROWSER_DONT_SUPPORT_VIDEO";
            delegate(data, false);
            return null;
        }

        var protocol = Connection.getProtocol();
        if (protocol != "https")
        {
            var data = Arr();
            data.error = "PROTOCOL_NOT_HTTPS";
            delegate(data, false);
            return null;
        }

        var videoOptions = true;

        if (facingMode == "user" || facingMode == "environment" || facingMode == "left" || facingMode == "right")
            videoOptions = { facingMode: facingMode };

        navigator.mediaDevices.getUserMedia({ video: videoOptions })
            .then(function(_stream)
            {
                var stream = File.Video.Stream.createByMediaStream(_stream);
                delegate(stream, true);
                return null;
            })
            .catch(function(err)
            {
                var error = err.toString().toLower().trim();

                if (error.startsWith("notallowederror")) {
                    var data = Arr();
                    data.error = "PERMISSION_DENIED";
                    delegate(data, false);
                    return null;
                }

                var data = Arr();
                data.error = err;
                delegate(data, false);
                return null;
            });
    };

})(window);
