(function(window) {

    window.File = (window.File || {});
    window.File.Audio = (window.File.Audio || {});

    File.Audio.recordByStream = function(stream, delegate)
    {
        if (window.MediaStream == null || window.MediaStream === undefined || stream == null ||
            stream === undefined || (stream instanceof File.Audio.Stream) == false ||
            window.MediaRecorder == null || window.MediaRecorder === undefined)
            return null;

        return new File.Audio.Record(stream, delegate);
    };

})(window);
