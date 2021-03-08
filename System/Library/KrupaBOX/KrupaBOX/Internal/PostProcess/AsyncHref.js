(function(window) {
    var __PostProcess__AsynHref__ = function()
    {
        this.isExecuting = false;
        this.currentResponse = null;
        this.cachedHrefs = [];
        this.cachedData = [];

        this.execute = function ()
        {
            var hrefs = Elements.find("[app-async-href]");
            if (hrefs == null) return null;

            for (var i = 0; i < hrefs.elements.length; i++)
                if (hrefs.elements[i] instanceof ElementEx)
                {
                    var uniqueId = hrefs.elements[i].uniqueId;

                    if (this.cachedHrefs[uniqueId] == null || this.cachedHrefs[uniqueId] == undefined)
                    {
                        this.cachedHrefs[uniqueId] = hrefs.elements[i];
                        this.cachedHrefs[uniqueId].style.set("cursor", "pointer");
                        this.cachedHrefs[uniqueId].event.onClick(function(event)
                        {
                            if (Internal.PostProcess.AsyncHref.isExecuting == true)
                                return null;
                            Internal.PostProcess.AsyncHref.isExecuting = true;

                            var target = event.target;
                            while (target != null && target.get("app-async-href") == null && target.tag != "html")
                                target = target.parent;

                            var href = target.get("app-async-href");
                            if (href != null)
                            {
                                var timeout = target.get("app-async-timeout");
                                timeout = intEx(timeout).toInt();
                                if (timeout <= 0) timeout = 0;

                                Internal.PostProcess.AsyncHref.callByUrlAndTimeout(href, timeout);
                            }
                        });
                    }
                }
        };

        this.callByUrlAndTimeout = function(href, timeout)
        {
            if (stringEx(href).startsWith("ftp://") || stringEx(href).startsWith("http://") || stringEx(href).startsWith("https://"))
            { Header.redirect(href); return null; }

            if (Internal.PostProcess.Events.onPrepareLoadEvent != null && Internal.PostProcess.Events.onPrepareLoadEvent != undefined)
                try { Internal.PostProcess.Events.onPrepareLoadEvent.onPrepareLoad(); } catch (e) { console.error(e); }

            var request = new Http.Request(href);
            request.data.isAsync = true;
            request.send(function(data, success)
            {
                if (success == false)
                {
                    if (Internal.PostProcess.Events.onLoadEvent != null && Internal.PostProcess.Events.onLoadEvent != undefined)
                        try { Internal.PostProcess.Events.onLoadEvent.onLoad(null, false); } catch (e) { console.error(e); }

                    console.error("Failed loading: " + href);
                    Internal.PostProcess.AsyncHref.isExecuting = false;
                    return null;
                }

                var response = Arr();
                response.html = stringEx(data).toString();
                response.body = ("" + response.html);
                response.url  = href;
                response.dataHash = null;
                response.timeout  = timeout;

                var bodyIndexOf = stringEx(response.body).indexOf("<body");
                if (bodyIndexOf >= 0 && bodyIndexOf != null)
                {
                    response.body = stringEx(response.body).subString(bodyIndexOf);

                    var bodyEndIndexOf = stringEx(response.body).indexOf("</body");
                    if (bodyEndIndexOf >= 0 && bodyEndIndexOf != null)
                    {
                        response.body = stringEx(response.body).subString(0, bodyEndIndexOf);

                        var bodyTagIndexOf = stringEx(response.body).indexOf(">");
                        if (bodyTagIndexOf >= 0 && bodyTagIndexOf != null)
                        { response.body = stringEx(response.body).subString(bodyTagIndexOf + 1);
                        } else response.body = null;
                    } else response.body = null;
                } else response.body = null;

                if (response.body != null)
                {
                    // Extract render data from backend
                    var internalScript = ("" + response.body);
                    var internalScriptIndexOf = stringEx(internalScript).indexOf("data-internal-script");

                    if (internalScriptIndexOf >= 0 && internalScriptIndexOf != null) {
                        internalScript = stringEx(internalScript).subString(0, internalScriptIndexOf - 2);

                        var internalScriptLastIndexOf = stringEx(internalScript).lastIndexOf("<");
                        if (internalScriptLastIndexOf >= 0 && internalScriptLastIndexOf != null) {
                            internalScript = stringEx(internalScript).subString(internalScriptLastIndexOf + 36);
                            internalScript = stringEx(internalScript).trim();
                            response.dataHash = internalScript;
                        }
                    }

                    response.body = response.body.replace(/<script[^>]*>.*?<\/script>/gi, '');
                    response.body = response.body.trim();
                }

                var renderHtml = false;
                if (Internal.PostProcess.Events.onLoadEvent != null && Internal.PostProcess.Events.onLoadEvent != undefined)
                    try { renderHtml = Internal.PostProcess.Events.onLoadEvent.onLoad(response, true); } catch (e) { console.error(e); }

                if (renderHtml !== false)
                {
                    // Check element for before injection
                    var prepareHtml = stringEx(response.body).toString();
                    var internalHook = Element.find("[data-internal-script='true']");
                    if (internalHook == null) {
                        console.error("Internal server error trying render page async");
                        Internal.PostProcess.AsyncHref.isExecuting = false;
                        return null;
                    }

                    Internal.PostProcess.AsyncHref.currentResponse = response;
                    Internal.PostProcess.AsyncHref.getData();

                } else Internal.PostProcess.AsyncHref.isExecuting = false;
            });
        };

        this.getData = function()
        {
            var dataHash = Internal.PostProcess.AsyncHref.currentResponse.dataHash;
            if (dataHash == null) {
                this.onReceiveData(null);
                return null;
            }

            if (this.cachedData[dataHash] != null && this.cachedData[dataHash] != undefined) {
                this.onReceiveData(this.cachedData[dataHash]);
                return null;
            }

            var request = new Http.Request(dataHash);
            request.send(function(data, success) {
                if (success == false) {
                    console.error("Failed get render data: " + dataHash);
                    this.onReceiveData(this.cachedData[dataHash]);
                    return null;
                }

                try { eval(data); } catch (e) { console.error(e); }

                var dataHtml = "";
                if ((dataHtml == null || dataHtml == "") &&
                    (window.__KrupaBOX_dataScript__ != undefined && window.__KrupaBOX_dataScript__ != null))
                    dataHtml = window.__KrupaBOX_dataScript__;

                try {
                    dataHtml = base64_decode(dataHtml);
                    data = JSON.parse(dataHtml);
                    dump(data);
                } catch(err) {}

                data = Arr(data);
                Internal.PostProcess.AsyncHref.cachedData[dataHash] = data;
                Internal.PostProcess.AsyncHref.onReceiveData(data);
                return null;
            });

            return null;
        };

        this.onReceiveData = function(data)
        {
            if (Internal.PostProcess.AsyncHref.currentResponse.timeout <= 0)
                Internal.PostProcess.AsyncHref.currentResponse.timeout = 1;

            setTimeout(function()
            {
                // Destroy elements
                var topElements = Element.find("body").childrens;
                if (topElements != null)
                    for (key in topElements.elements) {
                        if (topElements.elements.hasOwnProperty(key))
                        {
                            var bodyElement = topElements.elements[key];
                            if (bodyElement == undefined || bodyElement == null ||
                                (bodyElement.get("app-dont-destroy") == "true" || bodyElement.get("app-dont-destroy") === true) ||
                                bodyElement.tag == "script" || bodyElement.tag == "link" ||
                                (bodyElement.get("data-internal-script") == "true" || bodyElement.get("data-internal-script") === true))
                                continue;
                            bodyElement.destroy();
                        }
                    }

                var internalHook = Element.find("[data-internal-script='true']");
                if (internalHook == null) {
                    console.error("Internal server error trying render page async");
                    Internal.PostProcess.AsyncHref.isExecuting = false;
                    return null;
                }

                Internal.PostProcess.AsyncHref.isExecuting = false;

                internalHook.prependHTML(Internal.PostProcess.AsyncHref.currentResponse.body);
                Internal.PostProcess.Events.__lastAsyncHash__ = Internal.PostProcess.AsyncHref.currentResponse.url;

                window.history.pushState({
                    "html": "async: " + Internal.PostProcess.AsyncHref.currentResponse.url,
                    "pageTitle":""
                }, "", Internal.PostProcess.AsyncHref.currentResponse.url);

                PostProcess.callControllersInitialize(data);
                PostProcess.callControllerNamespace(data);

                window.setTimeout(function() {
                    if (Internal.PostProcess.Events.onRenderEvent != null && Internal.PostProcess.Events.onRenderEvent != undefined)
                        try { Internal.PostProcess.Events.onRenderEvent.onRender(null, false); } catch (e) { console.error(e); }
                }, 50);

                return null;

            }, Internal.PostProcess.AsyncHref.currentResponse.timeout);

            return null;
        };
    };

    window.Internal = (window.Internal || {});
    window.Internal.PostProcess = (window.Internal.PostProcess || {});
    window.Internal.PostProcess.AsyncHref = new __PostProcess__AsynHref__();
})(window);