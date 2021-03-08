(function(window) {
    var __PostProcess__Events__ = function()
    {
        this.__lastResolution__    = null;
        this.__blockMouseContext__ = false;
        this.__lastAsyncHash__     = null;

        this.onDocumentChangeEvent = null;
        this.onLoadEvent           = null;
        this.onRenderEvent         = null;
        this.onPrepareLoadEvent    = null;
        this.onMouseUpEvent        = null;
        this.onMouseDownEvent      = null;
        this.onMouseMoveEvent      = null;
        this.onNavigationUrlEvent  = null;
        this.onKeyDownEvent        = null;
        this.onKeyUpEvent          = null;

        this.lastLocationHash      = null;

        this.execute = function ()
        {
            this.onInitializeSystem();
            this.hookCloseEvent();
            this.hookResolutionEvent();
            this.hookDocumentChangeEvent();
            this.hookAsyncLoadEvent();
            this.hookMouseEvent();
            this.hookKeyEvent();
            this.hookNavigationEvent();
            this.hookFocusEvent();
        };

        this.onInitializeSystem = function ()
        {
            window.Controller = window.Application.Client.Controller;
            window.Component  = window.Application.Client.Component;
        };

        this.hookCloseEvent = function()
        {
            var closeEventNS = "application.client.event.onclose";
            var closeEvent = KrupaBOX.__internal__.__namespaces__[closeEventNS];

            if (closeEvent != null && closeEvent != undefined && closeEvent.onClose != null && closeEvent.onClose != undefined) {

                window.onbeforeunload = function (e) {
                    e = e || window.event;
                    var response = null;
                    try { response = closeEvent.onClose(); } catch (e) { console.error(e); }
                    if (response === undefined || response === false)
                        return null;
                    return response;
                }
            }
        };

        this.hookResolutionEvent = function()
        {
            var resolutionEventNS = "application.client.event.onresolutionchange";
            var resolutionEvent = KrupaBOX.__internal__.__namespaces__[resolutionEventNS];

            if (resolutionEvent != null && resolutionEvent != undefined && resolutionEvent.onResolutionChange != null && resolutionEvent.onResolutionChange != undefined)
            {
                Internal.PostProcess.Events.__lastResolution__ = Browser.getResolution();
                try { resolutionEvent.onResolutionChange(Browser.getResolution(Browser.getResolution())); } catch (e) { console.error(e); }

                window.setInterval(function() {
                    var currentResolution = Browser.getResolution();
                    if (currentResolution.width != Internal.PostProcess.Events.__lastResolution__.width || currentResolution.height != Internal.PostProcess.Events.__lastResolution__.height)
                    {
                        Internal.PostProcess.Events.__lastResolution__ = currentResolution;
                        try { resolutionEvent.onResolutionChange(Browser.getResolution(Browser.getResolution())); } catch (e) { console.error(e); }
                    }

                }, 25);
            }
        };

        this.hookDocumentChangeEvent = function()
        {
            var documentEventNS = "application.client.event.ondocumentchange";
            var documentEvent = KrupaBOX.__internal__.__namespaces__[documentEventNS];
            if (documentEvent != null && documentEvent != undefined && documentEvent.onDocumentChange != null && documentEvent.onDocumentChange != undefined)
            { Internal.PostProcess.Events.onDocumentChangeEvent = documentEvent; }

            var body = document.getElementsByTagName("body");
            if (body != null && body.length > 0) body = body[0]; else body = null;

            var config = { attributes: false, childList: true, subtree: true };
            var callback = function(_) {
                try { Internal.PostProcess.Events.__onDocumentChangeEvent__(); } catch (e) { console.error(e); }
                if (Internal.PostProcess.Events.onDocumentChangeEvent != null)
                    try { Internal.PostProcess.Events.onDocumentChangeEvent.onDocumentChange(); } catch (e) { console.error(e); }
            };

            var FallbackMutation = null;
            if (window.MutationObserver != null) FallbackMutation = window.MutationObserver;
            else if (window.WebKitMutationObserver != null) FallbackMutation = window.WebKitMutationObserver;
            if (FallbackMutation != null) {
                var observer = new FallbackMutation(callback);
                observer.observe(body, config);
            }
        };

        this.__onDocumentChangeEvent__ = function()
        {
            Internal.PostProcess.UniqueId.execute();
            Internal.PostProcess.AsyncHref.execute();
        };

        this.hookAsyncLoadEvent = function()
        {
            var loadEventNS = "application.client.event.onasyncload";
            var loadEvent = KrupaBOX.__internal__.__namespaces__[loadEventNS];
            if (loadEvent != null && loadEvent != undefined)
            {
                if (loadEvent.onLoad != null && loadEvent.onLoad != undefined)
                { Internal.PostProcess.Events.onLoadEvent = loadEvent; }

                if (loadEvent.onPrepareLoad != null && loadEvent.onPrepareLoad != undefined)
                { Internal.PostProcess.Events.onPrepareLoadEvent = loadEvent; }

                if (loadEvent.onRender != null && loadEvent.onRender != undefined)
                { Internal.PostProcess.Events.onRenderEvent = loadEvent; }
            }
        };

        this.hookMouseEvent = function()
        {
            var mouseEventNS = "application.client.event.onmouse";
            var mouseEvent = KrupaBOX.__internal__.__namespaces__[mouseEventNS];
            if (mouseEvent != null && mouseEvent != undefined)
            {
                if (mouseEvent.onMouseDown != null && mouseEvent.onMouseDown != undefined)
                { Internal.PostProcess.Events.onMouseDownEvent = mouseEvent; }

                if (mouseEvent.onMouseUp != null && mouseEvent.onMouseUp != undefined)
                { Internal.PostProcess.Events.onMouseUpEvent = mouseEvent; }

                if (mouseEvent.onMouseMove != null && mouseEvent.onMouseMove != undefined)
                { Internal.PostProcess.Events.onMouseMoveEvent = mouseEvent; }
            }

            var jQueryDoc = $(document);

            jQueryDoc.on("mousemove", "body", function(event)
            {
                var mousePosition = new Vector2(event.pageX, event.pageY);
                Input.Mouse.__currentPosition__ = mousePosition;
                var target = $(event.target);
                target = Element.find(target);

                if (Internal.PostProcess.Events.onMouseMoveEvent != null)
                { try { Internal.PostProcess.Events.onMouseMoveEvent.onMouseMove(mousePosition, target); } catch (e) { console.error(e); }}
            });

            if (Internal.PostProcess.Events.onMouseDownEvent != null)
            {
                jQueryDoc.on("contextmenu", function(event) {
                    if (Internal.PostProcess.Events.__blockMouseContext__ == true) {
                        event.preventDefault();
                        Internal.PostProcess.Events.__blockMouseContext__ = false;
                    }
                });

                jQueryDoc.on("mousedown", "body", function(event)
                {
                    var mousePosition = new Vector2(event.pageX, event.pageY);
                    var target = $(event.target);
                    target = Element.find(target);

                    var button = null;
                    if (event.which == 1)
                        button = Input.Mouse.BUTTON_LEFT;
                    else if (event.which == 2)
                        button = Input.Mouse.BUTTON_MIDDLE;
                    else if (event.which == 3)
                        button = Input.Mouse.BUTTON_RIGHT;
                    else button = event.which;

                    var response = null;
                    if (Internal.PostProcess.Events.onMouseDownEvent != null)
                    { try { response = Internal.PostProcess.Events.onMouseDownEvent.onMouseDown(button, mousePosition, target); } catch (e) { console.error(e); }}

                    if (response === false)
                    {
                        Internal.PostProcess.Events.__blockMouseContext__ = true;
                        Internal.PostProcess.Events.__blockInputEvent__(event);
                    }
                });
            }

            if (Internal.PostProcess.Events.onMouseUpEvent != null)
                jQueryDoc.on("mouseup", "body", function(event)
                {
                    var mousePosition = new Vector2(event.pageX, event.pageY);
                    var target = $(event.target);
                    target = Element.find(target);

                    var button = null;
                    if (event.which == 1)
                        button = Input.Mouse.BUTTON_LEFT;
                    else if (event.which == 2)
                        button = Input.Mouse.BUTTON_MIDDLE;
                    else if (event.which == 3)
                        button = Input.Mouse.BUTTON_RIGHT;
                    else button = event.which;

                    var response = null;
                    if (Internal.PostProcess.Events.onMouseUpEvent != null)
                    { try { response = Internal.PostProcess.Events.onMouseUpEvent.onMouseUp(button, mousePosition, target); } catch (e) { console.error(e); }}

                    if (response === false)
                        Internal.PostProcess.Events.__blockInputEvent__(event);
                });
        };

        this.__blockInputEvent__ = function(event)
        {
            if (event.stopPropagation)
                event.stopPropagation();
            else if (window.event)
                window.event.cancelBubble = true;
            event.preventDefault();
            return false;
        };

        this.hookKeyEvent = function()
        {
            var keyEventNS = "application.client.event.onkey";
            var keyEvent = KrupaBOX.__internal__.__namespaces__[keyEventNS];
            if (keyEvent != null && keyEvent != undefined)
            {
                if (keyEvent.onKeyDown != null && keyEvent.onKeyDown != undefined)
                { Internal.PostProcess.Events.onKeyDownEvent = keyEvent; }

                if (keyEvent.onKeyUp != null && keyEvent.onKeyUp != undefined)
                { Internal.PostProcess.Events.onKeyUpEvent = keyEvent; }
            }

            var htmlElement = jQueryKB("html");
            htmlElement.keydown(function(event) { return Internal.PostProcess.Events.__onKeyEvent__(event);  });
            htmlElement.keyup(function(event)   { return Internal.PostProcess.Events.__onKeyEvent__(event); });
        };

        this.__onKeyEvent__ = function(event)
        {
            var keyCode = toInt(event.keyCode);
            var key     = toString(event.key).toLower();
            var isDown  = (event.type == "keydown");

            var isKeyChanged = false;

            if (Input.Key.__keyCodes__.containsKey(keyCode) == false)
            {
                var keyData = Arr();
                keyData.keyCode = keyCode;
                keyData.isDown  = null;
                keyData.lastPressDown = null;
                keyData.lastPressUp   = null;
                Input.Key.__keyCodes__[keyCode] = keyData;
            }

            if (Input.Key.__keys__.containsKey(key) == false)
                Input.Key.__keys__[key] = Arr();
            if (Input.Key.__keys__[key].contains(keyCode) == false)
                Input.Key.__keys__[key].add(keyCode);

            if (Input.Key.__keyCodes__[keyCode].isDown !== isDown || Input.Key.__keyCodes__[keyCode].isDown === null)
                isKeyChanged = true;

            Input.Key.__keyCodes__[keyCode].lastKey = key;
            Input.Key.__keyCodes__[keyCode].isDown  = isDown;

            if (isKeyChanged == true)
            {
                if (isDown == true)
                    Input.Key.__keyCodes__[keyCode].lastPressDown = Time.now(true);
                else Input.Key.__keyCodes__[keyCode].lastPressUp = Time.now(true);

                var _keyData = Arr();
                _keyData.type = ((Input.Key.__keyCodes__[keyCode].isDown == true) ? "down" : "up");
                _keyData.key = Input.Key.__keyCodes__[keyCode].lastKey;
                _keyData.keyCode = keyCode;
                _keyData.combination = null;

                // Get combinations
                var _combinations = Arr();
                for (var _keyCode in Input.Key.__keyCodes__)
                    if (Input.Key.__keyCodes__.hasOwnProperty(_keyCode) && Input.Key.__keyCodes__)
                    {
                        var __keyData = Input.Key.__keyCodes__[_keyCode];
                        if (__keyData.isDown == true)
                            _combinations.add(__keyData);
                    }

                if (_combinations.count > 0)
                {
                    if (isDown == true)
                        _combinations.sort(function compare(a, b) {
                            if (a.lastPressDown < b.lastPressDown)
                                return -1;
                            if (a.lastPressDown > b.lastPressDown)
                                return 1;
                            return 0;
                        });
                    else _combinations.sort(function compare(a, b) {
                        if (a.lastPressUp < b.lastPressUp)
                            return -1;
                        if (a.lastPressUp > b.lastPressUp)
                            return 1;
                        return 0;
                    });

                    _keyData.combination = Arr();
                    for (var i = 0; i < _combinations.count; i++)
                    {
                        var combinationKeyData = Arr();
                        combinationKeyData.key = _combinations[i].lastKey;
                        combinationKeyData.keyCode = _combinations[i].keyCode;
                        _keyData.combination.add(combinationKeyData);
                    }
                }

                var response = null;

                if (isDown == true && Internal.PostProcess.Events.onKeyDownEvent != null)
                { try { response = Internal.PostProcess.Events.onKeyDownEvent.onKeyDown(_keyData); } catch (e) { console.error(e); }}
                else if (isDown == false && Internal.PostProcess.Events.onKeyUpEvent != null)
                { try { response = Internal.PostProcess.Events.onKeyUpEvent.onKeyUp(_keyData); } catch (e) { console.error(e); }}

                return response;
            }
        };

        this.updateFixed = function()
        {
            var currentLocation = (location.pathname + location.search);
            if (this.lastLocationHash == null)
                this.lastLocationHash = currentLocation;
            if (this.lastLocationHash != currentLocation)
            {
                // dump(this.__lastAsyncHash__ + " -> " + currentLocation + " -> " + this.lastLocationHash);

                if (currentLocation != this.__lastAsyncHash__) {
                    this.__lastAsyncHash__ = null;
                    this.onLocationChange(currentLocation);
                }
                this.lastLocationHash = currentLocation;
            }
        };

        this.hookNavigationEvent = function()
        {
            var navigationEventNS = "application.client.event.onnavigation";
            var navigationEvent = KrupaBOX.__internal__.__namespaces__[navigationEventNS];
            if (navigationEvent != null && navigationEvent != undefined)
            {
                if (navigationEvent.onUrlChange != null && navigationEvent.onUrlChange != undefined)
                { Internal.PostProcess.Events.onNavigationUrlEvent = navigationEvent; }
            }
        };

        this.onLocationChange = function(currentLocation)
        {
            var response = null;
            if (Internal.PostProcess.Events.onNavigationUrlEvent != null)
            { try { response = Internal.PostProcess.Events.onNavigationUrlEvent.onUrlChange(currentLocation); } catch (e) { console.error(e); }}
            if (response !== false)
                Header.redirectAsync(currentLocation);
        };

        this.hookFocusEvent = function()
        {
            var focusEventNS = "application.client.event.onfocus";
            var focusEvent = KrupaBOX.__internal__.__namespaces__[focusEventNS];

            if (focusEvent != null && focusEvent != undefined && focusEvent.onFocus != null && focusEvent.onFocus != undefined)
            {
                window.onfocus = function() {
                    var response = null;
                    try { response = focusEvent.onFocus(true); } catch (e) { console.error(e); }
                    if (response === undefined || response === false)
                        return null;
                    return response;
                };

                window.onblur = function() {
                    var response = null;
                    try { response = focusEvent.onFocus(false); } catch (e) { console.error(e); }
                    if (response === undefined || response === false)
                        return null;
                    return response;
                };

                try { focusEvent.onFocus(document.hasFocus()); } catch (e) { console.error(e); }
            }
        };

    };

    window.Internal = (window.Internal || {});
    window.Internal.PostProcess = (window.Internal.PostProcess || {});
    window.Internal.PostProcess.Events = new __PostProcess__Events__();
})(window);