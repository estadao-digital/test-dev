(function(window) {
    var __PostProcess__ = function()
    {
        this.__isDevelopment__ = "{{ development }}";

        this.updates = {
            update: [],
            fixed: [],
            long: []
        };

        this.data = null;

        this.execute = function ()
        {
            this.preInitialize();
            var buildData = this.getServerData();

            this.externalCalls();

            this.callControllersAwake(buildData);
            this.callControllersInitialize(buildData);
            this.callControllerNamespace(buildData);

            this.checkUpdaters();
            this.finish();
        };

        this.preInitialize = function()
        {
            // Fix classes on html + powered by
            var html = Element.find("html");
            html.set("x-powered-by", "KrupaBOX");

            // Modernizr classes (may duplicated)
            var classes = html.class;
            html.set("class", "");
            var cleanClasses = Arr();

            var _classes = "";
            for (var i = 0; i < classes.classes.length; i++)
                _classes[_classes.length] = (classes.classes[i] + " ");

            if (classes.split != null)
            {
                classes = classes.split(" ");

                for (var i = 0; i < classes.length; i++)
                    if (classes[i] != "" && cleanClasses.contains(classes[i]) == false)
                        cleanClasses.add(classes[i]);
                for (var i = 0; i < cleanClasses.length; i++)
                    html.class.add(cleanClasses[i]);

                if (html.get("class") === "")
                    html.attribute.remove("class");
            }

            // Exit function
            window.__internalDestroy__ = function() {
                var html = Element.find("html");
                if (html == null)
                    return null;

                html.destroy();

                window.KrupaBOX = undefined;
                window.Application = undefined;

                window.__defineGetter__('exit', function() { return undefined; });
                window.__defineGetter__('die', function() { return undefined; });
                };

            window.__defineGetter__('exit', function() { window.__internalDestroy__(); return (function(message) { if (message != undefined) console.error(message); window.__internalDestroy__(); }); });
            window.__defineGetter__('die', function() { window.__internalDestroy__(); return (function(message) { if (message != undefined) console.error(message); window.__internalDestroy__(); }); });
        };

        this.externalCalls = function()
        {
            if (window.__InternetExplorerPolyfill__ !== null && window.__InternetExplorerPolyfill__ !== undefined)
                window.__InternetExplorerPolyfill__();

            var data = Arr(this.data);

            if (data.global.front.support.containsKey("prefix") && data.global.front.support.prefix == true)
                Internal.PostProcess.AutoPrefix.execute();
        };

        this.getServerData = function()
        {
            var data = Arr();

            var dataHtml = "";
            // var dataScript = Element.find("[data-script='data']");
            // if (dataScript != null)
            //     var dataHtml = dataScript.get("html");

            if ((dataHtml == null || dataHtml == "") &&
                (window.__KrupaBOX_dataScript__ != undefined && window.__KrupaBOX_dataScript__ != null))
                    dataHtml = window.__KrupaBOX_dataScript__;

            // if (dataHtml == null || dataHtml == "")
            //     dataHtml = "\"\"";
            //
            // if (dataHtml.length > 0) dataHtml = dataHtml.substring(1);
            // if (dataHtml.length > 0) dataHtml = dataHtml.substring(0, dataHtml.length - 1);

            // dataHtml = decodeURIComponent(dataHtml);
            // data = JSON.parse(dataHtml);

            try {
                // dataHtml = decodeURIComponent(dataHtml);
                dataHtml = base64_decode(dataHtml);
                data = JSON.parse(dataHtml);
                dumpEx(data);
            } catch(err) {}

            this.data = Arr(data);
            return this.data;
        };

        this.callControllersAwake = function(buildData)
        {
            for (var namespace in KrupaBOX.__internal__.__namespaces__)
                if (KrupaBOX.__internal__.__namespaces__.hasOwnProperty(namespace))
                {
                    var _controller = KrupaBOX.__internal__.__namespaces__[namespace];
                    if (_controller.onAwake != null && typeOf(_controller.onAwake) == "function")
                        try { _controller.onAwake(buildData); } catch (e) { console.error(e); }
                }
        };

        this.callControllersInitialize = function(buildData)
        {
            for (var namespace in KrupaBOX.__internal__.__namespaces__)
                if (KrupaBOX.__internal__.__namespaces__.hasOwnProperty(namespace))
                {
                    var _controller = KrupaBOX.__internal__.__namespaces__[namespace];
                    if (_controller.onInitialize != null && typeOf(_controller.onInitialize) == "function")
                        try { _controller.onInitialize(buildData); } catch (e) { console.error(e); }
                }
        };

        this.callControllerNamespace = function(buildData)
        {
            this.hookEvents();

            var routeEventNS = "application.client.event.onroute";
            var routeEvent = KrupaBOX.__internal__.__namespaces__[routeEventNS];

            if (routeEvent != null && routeEvent != undefined && routeEvent.onRoute != null && routeEvent.onRoute != undefined) {
                var routeData = routeEvent.onRoute(window.location.pathname);
                if (routeData instanceof Router) {
                    var matchRoute = routeData.execute();
                    if (matchRoute != null && matchRoute.controller.onRequest != null && matchRoute.controller.onRequest != undefined) {
                        try { matchRoute.controller.onRequest(buildData); } catch (e) { console.error(e); }
                        return null;
                    }
                }
            }

            var namespace = window.location.pathname;
            if (namespace.startsWith("/"))
                namespace = namespace.substring(1, namespace.length);
            if (namespace.endsWith("/"))
                namespace = namespace.substring(0, namespace.length - 1);

            namespace = namespace.
                replaceAll("\\", "/").
                replaceAll("//", "/").
                replaceAll("/", ".");

            var fullNamespace = String("Application.Client.Controller." + namespace).toLower();
            if (KrupaBOX.__internal__.__namespaces__[fullNamespace] != null) {
                var _controller = KrupaBOX.__internal__.__namespaces__[fullNamespace];
                if (_controller.onRequest != null && typeof(_controller.onRequest) == "function")
                    try { _controller.onRequest(buildData); } catch (e) { console.error(e); }
            }
        };

        this.hookEvents = function()
        { Internal.PostProcess.Events.execute(); };

        this.checkUpdaters = function()
        {
            for (var namespace in KrupaBOX.__internal__.__namespaces__)
                if (KrupaBOX.__internal__.__namespaces__.hasOwnProperty(namespace))
                {
                    var _controller = KrupaBOX.__internal__.__namespaces__[namespace];

                    if (_controller.onUpdateFixed != null && typeOf(_controller.onUpdateFixed) == "function")
                        this.updates.fixed[this.updates.fixed.length] = _controller.onUpdateFixed;
                    if (_controller.onUpdate != null && typeOf(_controller.onUpdate) == "function")
                        this.updates.update[this.updates.update.length] = _controller.onUpdate;
                    if (_controller.onUpdateLong != null && typeOf(_controller.onUpdateLong) == "function")
                        this.updates.long[this.updates.long.length] = _controller.onUpdateLong;
                }

            //if (this.updates.fixed.length > 0) // For "onhashChange" works
            this.callControllerUpdateFixed();
            if (this.updates.update.length > 0)
                this.callControllerUpdate();
            if (this.updates.long.length > 0)
                this.callControllerUpdateLong();
        };

        this.callControllerUpdateFixed = function()
        {
            for (var key in this.updates.fixed)
                if (this.updates.fixed.hasOwnProperty(key) && key != "length")
                {
                    var updateFunction = this.updates.fixed[key];
                    try { updateFunction(100);  }
                    catch(err) { console.error(err);  }
                }

            Internal.PostProcess.Events.updateFixed();
            setTimeout(function(){ PostProcess.callControllerUpdateFixed(); }, 100);
        };

        this.callControllerUpdate = function()
        {
            for (var key in this.updates.update)
                if (this.updates.update.hasOwnProperty(key) && key != "length")
                {
                    var updateFunction = this.updates.update[key];
                    try { updateFunction(200);  }
                    catch(err) { console.error(err);  }
                }

            setTimeout(function(){ PostProcess.callControllerUpdate(); }, 200);
        };

        this.callControllerUpdateLong = function()
        {
            for (var key in this.updates.long)
                if (this.updates.long.hasOwnProperty(key) && key != "length")
                {
                    var updateFunction = this.updates.long[key];
                    try { updateFunction(500);  }
                    catch(err) { console.error(err);  }
                }

            setTimeout(function(){ PostProcess.callControllerUpdateLong(); }, 500);
        };

        this.finish = function()
        {

        };
    };

    window.PostProcess = new __PostProcess__();
    PostProcess.execute();

})(window);