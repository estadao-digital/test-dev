(function(window) {
    window.Http = window.Http || {};
    Http.Request = function(url)
    {
        this.url      = null;
        this.data     = {};
        this.dataType = "text";
        this.method   = "get";

        this.constructor = function(url)
        { this.url = url; };

        this.send = function(callback, progressCallback)
        {
            if (this.data instanceof Array)
                this.data = this.data.toObject();

            for (var key in this.data)  {
                if (!this.data.hasOwnProperty(key)) continue;
                if (this.data[key] instanceof Array)
                    this.data[key] = this.data[key].toObject();
                else this.data[key] = this.data[key];
            }

            if (this.method != "get" && this.method != "post" && this.method != "delete")
                this.method = "get";

            if (this.dataType == "json")
            {
                var _request = jQueryKB.ajax({
                    url: this.url,
                    type: this.method.toUpper(),
                    dataType: "json",
                    data: this.data,
                    success: function (data) {
                        if (typeof (callback) === 'function')
                        { callback(Arr(data), true); }
                    },
                    error: function(data, textStatus, errorThrown) {
                        var isKrupaBoxError = false;
                        var getInternalError = data.getResponseHeader('KrupaBOX-Error');
                        if (getInternalError != null && getInternalError == "true")
                            isKrupaBoxError = true;

                        var responseData = null;

                        var response = ((data.responseText != null && data.responseText != "") ? data.responseText : null);
                        if (response != null) try { responseData = Serialize.Json.decode(response); } catch(e) {}

                        if (responseData != null)
                            responseData = Arr(responseData);
                        else if (isKrupaBoxError == true)
                        {
                            var error = "unknown";
                            var file  = "unknown";
                            var line  = "unknown";

                            if (response != null)
                            {
                                var extractErrorIndexOf = response.indexOf("KRUPABOX_INIT_ERROR_JSON");
                                var extractError = response.subString(extractErrorIndexOf + 25);
                                extractErrorIndexOf = extractError.indexOf("KRUPABOX_END_ERROR_JSON");
                                extractError = extractError.subString(0, extractErrorIndexOf - 1);

                                var decodeResponse = Serialize.Json.decode(extractError);
                                if (decodeResponse.length >= 3) {
                                    error = decodeResponse[0];
                                    file  = decodeResponse[1];
                                    line  = decodeResponse[2];
                                }
                            }

                            console.error("Backend error: " + error + "\n" + "File: " + file + " (line " + line + ")");
                        }

                        if (typeof (callback) === 'function')
                        {
                            callback(responseData, false);
                        }
                    }
                });

                //     onProgress: function (event)
                //     {
                //         var loaded = event.loaded, total = event.total;
                //         var percent = parseInt(loaded / total * 100, 10);
                //
                //         if (percent < 0 || percent > 100) percent = 0;
                //         if (percent != 0) percent = (percent / 100); // now 0-1
                //
                //         if (progressCallback != null)
                //             progressCallback(percent);
                //     }
                // }));
                //
                // if (this.method == "get")
                //     _request.get(this.data);
                // else if (this.method == "post")
                //     _request.post(this.data);
            }
            else if (this.dataType == "text")
            {
                var _request = jQueryKB.ajax({
                    url: this.url,
                    type: this.method.toUpper(),
                    dataType: "text",
                    data: this.data,
                    success: function (data) {
                        if (typeof (callback) === 'function')
                        { callback(data, true); }
                    },
                    error: function(data, textStatus, errorThrown) {
                        var responseData = null;

                        var response = ((data.responseText != null && data.responseText != "") ? data.responseText : null);
                        if (response != null) responseData = Serialize.Json.decode(response);

                        if (typeof (callback) === 'function')
                        { callback(null, false); }
                    }
                });
            }
        };

        this.constructor(url);
        return this;
    };
    window.Http__Request = window.Http.Request;
})(window);
