try {
    if (!Object.prototype.__defineGetter__ &&
        Object.defineProperty({},"x",{get: function(){return true}}).x) {
        Object.defineProperty(Object.prototype, "__defineGetter__",
            {enumerable: false, configurable: true,
                value: function(name,func)
                {Object.defineProperty(this,name,
                    {get:func,enumerable: true,configurable: true});
                }});
        Object.defineProperty(Object.prototype, "__defineSetter__",
            {enumerable: false, configurable: true,
                value: function(name,func)
                {Object.defineProperty(this,name,
                    {set:func,enumerable: true,configurable: true});
                }});
    }
} catch(defPropException) {/*Do nothing if an exception occurs*/};

window.__InternetExplorerPolyfill__ = function()
{
    var browser = Browser.getBrowser();
    var version = Browser.getBrowserVersion(true);

    if (browser != null && browser.toLower() == "internet explorer")
    {
        if (version <= 10 && (window.PointerEvent === null || window.PointerEvent === undefined))
        {
            var allElements = Elements.find("*");
            if (allElements != null)
                for (var i = 0; i < allElements.elements.count; i++)
                {
                    var element = allElements.elements[i];
                    var pointerEventsAttr = element.style.get("pointer-events");
                    if (pointerEventsAttr == "none")
                    {
                        var elementId = element.get("id");
                        var containsId = (elementId !== undefined && elementId !== null);

                        if (containsId == false) {
                            element.set("id", "pointer-events-" + i.toString());
                            elementId = element.get("id");
                        }

                        $(document).on('mousedown', ("#" + elementId), function (e) {
                            $(this).hide();
                            var bottomElement = document.elementFromPoint(e.clientX, e.clientY);
                            var jBottomElement = $(bottomElement);
                            jBottomElement.click();
                            $(this).show();
                        });
                    }
                }
        }
    }
};
