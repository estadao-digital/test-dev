(function(window) {

    window.File = (window.File || {});
    window.File.Video = (window.File.Video || {});
    window.File.Video.Stream = (window.File.Video.Stream || {});

    File.Video.Stream = (function ()
    {
        this.mediaStream = null;
        this._isRunning   = false;

        this.close = function () { this.stop(); };

        this.stop = function ()
        {
            if (this.mediaStream == null || this._isRunning == false)
                return null;

            if (this.mediaStream != null) {
                this.mediaStream.getAudioTracks().forEach(function (track) { track.stop(); });
                this.mediaStream.getVideoTracks().forEach(function (track) { track.stop(); });
            }

            this._isRunning = false;
        };

        this.isRunning = function() { return (this.mediaStream != null && this._isRunning == true); };

        this.destroy = function() {
            this.stop();
            this.mediaStream = null;
        };
    });

    File.Video.Stream.createByMediaStream = function(mediaStream)
    {
        if (window.MediaStream == null || window.MediaStream === undefined || mediaStream == null ||
            mediaStream === undefined || (mediaStream instanceof MediaStream) == false)
            return null;

        var stream = new File.Video.Stream();
        stream.mediaStream = mediaStream;
        stream._isRunning   = true;
        return stream;
    };

})(window);
