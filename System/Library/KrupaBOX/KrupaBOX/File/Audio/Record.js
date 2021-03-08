(function(window) {

    window.File = (window.File || {});
    window.File.Audio = (window.File.Audio || {});
    window.File.Audio.Record = (window.File.Audio.Record || {});

    File.Audio.Record = (function (stream, delegate)
    {
        this.delegateOnData  = null;
        this.delegateOnStop  = null;

        this.mediaStream = null;
        this.mediaRecorder = null;
        this.recordChunks  = null;

        this.checkInterval = null;

        this._isRecording   = false;
        this._isPaused      = false;

        this.blob = null;
        this.blobUrl = null;

        this.constructor = function(stream, delegate)
        {
            var canRecord = true;

            if (File.Audio.Record.isSupported() == false || stream == null ||
                stream === undefined || (stream instanceof File.Audio.Stream) == false)
                canRecord = false;

            if (canRecord == true)
            {
                if (FunctionEx.isFunction(delegate) != false)
                    this.delegateOnData = delegate;

                this.mediaStream   = stream;
                this.mediaRecorder = new MediaRecorder(stream.mediaStream);
                if (this.mediaRecorder != null)
                {
                    var myThis = this;

                    this.mediaRecorder.ondataavailable = function(event) {
                        myThis.recordChunks.push(event.data);
                        if (myThis.delegateOnData != null)
                            myThis.delegateOnData(event.data);
                    };
                }
            }
        };

        this.onUpdate = function()
        {
            if (this.mediaStream.isRunning() == false)
            {
                if (this.checkInterval != null)
                    window.clearInterval(this.checkInterval);
                this.stop();
                return null;
            }
        };

        this.start = function()
        {
            if (this.mediaRecorder == null || this._isRecording == true || this.mediaStream.isRunning() == false)
                return null;

            this.recordChunks = [];
            this.blob         = null;
            this.blobUrl      = null;

            this._isPaused     = false;
            this._isRecording  = true;

            var myThis = this;
            this.checkInterval = window.setInterval(function() {
                myThis.onUpdate();
            }, 25);

            this.mediaRecorder.start(25);
        };

        this.pause = function(enabled)
        {
            if (enabled === null || enabled === undefined)
                enabled = true;
            if (this.mediaRecorder == null || this._isRecording == false)
                return null;

            if (enabled == true && this._isPaused == true)
                this.mediaRecorder.resume();
            else if (enabled == false && this._isPaused == false)
                this.mediaRecorder.pause();

            this._isPaused = enabled;
        };

        this.stop = function()
        {
            if (this.mediaRecorder == null || this._isRecording == false)
                return null;

            this.mediaRecorder.stop();
            if (this.checkInterval != null)
                window.clearInterval(this.checkInterval);

            this._isRecording = false;
            this._isPaused    = false;

            if (this.delegateOnStop != null)
                this.delegateOnStop(this);
        };

        this.onData = function(onDataDelegate) {
            if (FunctionEx.isFunction(onDataDelegate))
                this.delegateOnData = onDataDelegate;
        };

        this.onStop = function(onStopDelegate) {
            if (FunctionEx.isFunction(onStopDelegate))
                this.delegateOnStop = onStopDelegate;
        };

        this.getBlob = function(stop)
        {
            this.stop();
            if (this.blob != null)
                return this.blob;

            if (this.recordChunks.count <= 0)
                return null;

            var type = this.recordChunks[0].type;
            this.blob = new Blob(this.recordChunks, { 'type' : type });

            return this.blob;
        };

        this.getBlobURL = function()
        {
            if (this.blobUrl != null)
                return this.blobUrl;

            if (window.URL === null || window.URL === undefined)
                return null;

            var blob = this.getBlob();
            if (blob == null) return null;

            this.blobUrl = window.URL.createObjectURL(blob);
            return this.blobUrl;
        };

        this.getDataURL = function(delegate)
        {
            var blob = this.getBlob();
            if (blob == null) return null;

            var fileReader = new FileReader();
            fileReader.addEventListener("load", function () {
                if (FunctionEx.isFunction(delegate) == true)
                    delegate(fileReader.result, fileReader.error);
            }, false);

            fileReader.readAsDataURL(blob);
        };

        this.constructor(stream, delegate);
    });

    File.Audio.Record.isSupported = function() {
        return (!(window.MediaStream == null || window.MediaStream === undefined ||
            window.MediaRecorder == null || window.MediaRecorder === undefined));
    }

})(window);
