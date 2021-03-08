(function(window) {

    window.Input = (window.Input || {});
    Input.Audio = {};

    Input.Audio.getStream = function(delegate)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        if (window.navigator !== null && window.navigator !== undefined)
            navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

        if (window.navigator == null || window.navigator === undefined || navigator.mediaDevices == null ||
            navigator.mediaDevices === undefined || navigator.mediaDevices.getUserMedia == null || navigator.mediaDevices.getUserMedia === undefined)
        {
            var data = Arr();
            data.error = "BROWSER_DONT_SUPPORT_AUDIO";
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

        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(_stream)
            {
                var stream = File.Audio.Stream.createByMediaStream(_stream);
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

    Input.Audio.getSpeech = function(delegate, speechDelegate)
    {
        if (FunctionEx.isFunction(delegate) == false || FunctionEx.isFunction(speechDelegate) == false)
            return null;

        Input.Audio.getStream(function(stream, success)
        {
            if (success === false)
            { delegate(stream, success); return null; }

            stream.stop();

            if (window.annyangKB === null || window.annyangKB === undefined)
            {
                var data = Arr();
                data.error = "BROWSER_DONT_SUPPORT_SPEECH";
                delegate(data, false);
                return null;
            }

            Input.Audio.Speech.__delegate__ = speechDelegate;
            Input.Audio.Speech.stop();
            Input.Audio.Speech.start();

            var data = Arr();
            delegate(Input.Audio.Speech, true);
            return null;
        });
    }

})(window);
