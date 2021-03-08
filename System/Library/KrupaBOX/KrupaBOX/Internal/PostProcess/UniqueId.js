(function(window) {
    var __PostProcess__UniqueId__ = function()
    {
        this.uniqueIds = [];
        this.lastUniqueId = 0;

        this.execute = function ()
        {
            var uniqueIdsElements = Elements.find("[app-uniqueId]");
            if (uniqueIdsElements != null)
                for (var i = 0; i < uniqueIdsElements.elements.length; i++)
                    if (uniqueIdsElements.elements[i] instanceof ElementEx)
                        Internal.PostProcess.UniqueId.getUniqueId(uniqueIdsElements.elements[i]);
        };

        this.getUniqueId = function (elementEx)
        {
            if (elementEx instanceof ElementEx)
            {
                var uniqueId = elementEx.get("app-uniqueId");
                if (uniqueId != null && uniqueId != undefined)
                {
                    if (this.uniqueIds[uniqueId] == null || this.uniqueIds[uniqueId] == undefined ||
                        this.uniqueIds[uniqueId].element == null || this.uniqueIds[uniqueId].element == undefined)
                        uniqueId = null;
                    else if (this.uniqueIds[uniqueId].element.isEqualNode(elementEx.element) == false)
                    { uniqueId = null; }
                }

                if (uniqueId == null || uniqueId == undefined)
                {
                    this.lastUniqueId += 1;
                    uniqueId = (0 + this.lastUniqueId);
                    elementEx.set("app-uniqueId", uniqueId);
                }

                this.uniqueIds[uniqueId] = elementEx;
                return intEx(uniqueId).toInt();
            }
        }
    };

    window.Internal = (window.Internal || {});
    window.Internal.PostProcess = (window.Internal.PostProcess || {});
    window.Internal.PostProcess.UniqueId = new __PostProcess__UniqueId__();
})(window);