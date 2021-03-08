(function(window) {

    window.ElementEx = function(element) {
        this.element = null;
        this.__jQueryElement__ = null;

        this.constructor = function(element)
        { this.element = element; this.__defineProperties__(); };

        this.constructor(element);
        return this;
    };

    ElementEx.fromNative = function(element) {
        return new ElementEx(element);
    };
    Element.fromNative = ElementEx.fromNative;

    ElementEx.find = function(searchQuery)
    {
        var found = null;

        if (searchQuery instanceof ElementEx)
            return searchQuery;

        if ((searchQuery instanceof jQuery || searchQuery instanceof jQueryKB) == false)
            searchQuery = String(searchQuery).toString();

        found = window.jQueryKB(searchQuery);
        return (found.length > 0) ? (new ElementEx(found[0])) : null;
    };
    Element.find = ElementEx.find;

    ElementEx.getRoot = function()
    { return Element.find("html"); };
    Element.getRoot = ElementEx.getRoot;

    ElementEx.getBody = function(createIfNotExists)
    {
        var body = Element.find("body");
        if (body == null && createIfNotExists == true) {
            var root = ElementEx.getRoot();
            root.appendHTML("<body></body>");
            return ElementEx.getBody(false);
        }
        return body;
    };
    Element.getBody = ElementEx.getBody;

    ElementEx.add = function(tag)
    {
        if (tag === undefined || tag === null) return null;
        tag = tag.toString().toLowerCase(); if (tag.isEmpty()) return null;

        var elementHash = sha1(tag + rand(1, 100000));
        var htmlElement = ("<" + tag + " data-internal-hash=\"" + elementHash + "\">");
        if (tag !== "br") htmlElement += ("</" + tag + ">");

        ElementEx.body.appendHTML(htmlElement);

        var findElement = ElementEx.find("[data-internal-hash='" + elementHash + "']");
        if (findElement == null) return null;

        findElement.attribute.remove("data-internal-hash");
        return findElement;
    };
    Element.add = ElementEx.add;

    Object.defineProperty(window.ElementEx, "body", {
        get: function () { return window.ElementEx.getBody(); }
    });

    Object.defineProperty(window.ElementEx, "root", {
        get: function () { return window.ElementEx.getRoot(); }
    });

    Object.defineProperty(window.Element, "body", {
        get: function () { return window.ElementEx.body; }
    });

    Object.defineProperty(window.Element, "root", {
        get: function () { return window.ElementEx.root; }
    });

    ElementEx.getById = function(id) { return ElementEx.find("#" + id); };
    Element.getById = ElementEx.getById;

    ElementEx.getByUniqueId = function(uniqueId)
    {
        var uniqueIds = Elements.find("[app-uniqueId='" + uniqueId + "']");
        if (uniqueIds != null)
            for (var i = 0; i < uniqueIds.elements.length; i++)
                if (uniqueIds.elements[i] instanceof ElementEx)
                    Internal.PostProcess.UniqueId.getUniqueId(uniqueIds.elements[i]);

        var uniqueIdElement = Element.find("[app-uniqueId='" + uniqueId + "']");
        return uniqueIdElement;
    };
    Element.getByUniqueId = ElementEx.getByUniqueId;

    ElementEx.getFocused = function()
    {
        var _element = new ElementEx(document.activeElement);
        return _element;
    };
    Element.getFocused = ElementEx.getFocused;

    ElementEx.prototype.get = function (key)
    {
        if (this.element == null) return null;
        key = String(key).toString();
        key = key.toLowerCase();

        if (key == "html")
            return (this.jQueryKB.html());
        else if (key == "value")
            return (this.jQueryKB.val());
        else if (key == "checked")
            return (this.jQueryKB.prop('checked'));
        else if (key == "disabled")
            return (this.jQueryKB.prop('disabled'));
        else if (key == "width")
            return (this.jQueryKB.width());
        else if (key == "height")
            return (this.jQueryKB.height());
        else if (key == "uniqueid")
            return (Internal.PostProcess.UniqueId.getUniqueId(this));
        else if (key == "parent")
            return (Element.find(this.jQueryKB.parent()));
        else if (key == "tag")
            return stringEx(this.jQueryKB.prop("tagName")).toLower();

        return this.attribute.get(key);
    };

    ElementEx.prototype.set = function (key, value)
    {
        if (this.element == null) return null;
        key = String(key).toString();
        key = key.toLowerCase();

        if (key == "html")
            return (this.jQueryKB.html(value));
        else if (key == "value")
            return (this.jQueryKB.val(value));
        else if (key == "checked")
            return (this.jQueryKB.prop('checked', value));
        else if (key == "disabled")
            return (this.jQueryKB.prop("disabled", value));
        else if (key == "width")
            return (this.jQueryKB.prop("width", value));
        else if (key == "height")
            return (this.jQueryKB.prop("height", value));
        else if (key == "parent")
        {
            if ((value instanceof ElementEx) == false)
                return false;
            this.jQueryKB.appendTo(value.jQueryKB);
            return true;
        }

        return this.attribute.set(key, value);
    };

    ElementEx.prototype.destroy = function ()
    {
        if (this.element == null) return null;
        return this.jQueryKB.remove();
    };

    ElementEx.prototype.find = function(searchQuery, multiple)
    {
        if (this.element == null) return null;
        searchQuery = String(searchQuery).toString();
        var found = (this.jQueryKB.find(searchQuery));

        if (multiple == true) {
            if (found.length <= 0) return null;
            var elements = new Elements();
            for (var i = 0; i < found.length; i++)
                elements.add(new ElementEx(found[i]));
            return elements;
        }

        return (found.length > 0) ? (new ElementEx(found[0])) : null;
    };

    ElementEx.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "html", {
            get: function () { return this.get("html"); },
            set: function (value) { this.set("html", value); }
        });

        Object.defineProperty(this, "value", {
            get: function () { return this.get("value"); },
            set: function (value) { this.set("value", value); }
        });

        Object.defineProperty(this, "isChecked", {
            get: function () { return this.get("checked"); },
            set: function (value) { this.set("checked", value); }
        });

        Object.defineProperty(this, "uniqueId", {
            get: function () { return this.get("uniqueId"); }
        });

        Object.defineProperty(this, "parent", {
            get: function () { return this.get("parent"); },
            set: function (value) { this.set("parent", value); }
        });

        Object.defineProperty(this, "tag", {
            get: function () { return this.get("tag"); }
        });

        Object.defineProperty(this, "childrens", {
            get: function () { return this.getChildrens(); }
        });

        Object.defineProperty(this, "class", {
            get: function () { return new ElementEx.ClassEx(this); }
        });

        Object.defineProperty(this, "width", {
            get: function () { return this.get("width"); },
            set: function (value) { return this.set("width", value); }
        });

        Object.defineProperty(this, "height", {
            get: function () { return this.get("height"); },
            set: function (value) { return this.set("height", value); }
        });

        Object.defineProperty(this, "isDisabled", {
            get: function () { return this.get("disabled"); }
        });

        Object.defineProperty(this, "attribute", {
            get: function () { return new ElementEx.Attribute(this); }
        });

        Object.defineProperty(this, "event", {
            get: function () { return new ElementEx.Event(this); }
        });

        Object.defineProperty(this, "style", {
            get: function () { return new ElementEx.Style(this); }
        });

        Object.defineProperty(this, "file", {
            get: function () { return new ElementEx.File(this); }
        });

        Object.defineProperty(this, "scroll", {
            get: function () { return new ElementEx.Scroll(this); }
        });

        Object.defineProperty(this, "jQuery", {
            get: function () {
                if (window.jQuery != null) return window.jQuery(this.element);
                return window.jQueryKB(this.element);
            }
        });

        Object.defineProperty(this, "jQueryKB", {
            get: function () { return window.jQueryKB(this.element); }
        });
    };

    ElementEx.prototype.click = function() { this.element.click(); };

    ElementEx.prototype.appendHTML = function(html, after)
    {
        after = ((after === true) ? true : false);

        if (after == true) {
            this.jQueryKB.after(html);
            return null;
        }

        this.jQueryKB.append(html);
    };

    ElementEx.prototype.prependHTML = function(html) { this.jQueryKB.before(html); }

    // Fallback to old KrupaBOX versions
    ElementEx.prototype.onClick  = function(delegate)  { return this.event.onClick(delegate);   };
    ElementEx.prototype.onChange = function(delegate)  { return this.event.onChange(delegate);   };
    ElementEx.prototype.onInput  = function(delegate)  { return this.event.onInput(delegate);   };
    ElementEx.prototype.addClass = function(_class)    { return this.class.add(_class); };
    ElementEx.prototype.removeClass = function(_class) { return this.class.remove(_class); };
    ElementEx.prototype.hasClass = function(_class)    { return this.class.contains(_class); };
    ElementEx.prototype.containsAttribute = function (attribute)  { return this.attribute.contains(attribute); };
    ElementEx.prototype.setAttribute = function(attribute, value) { return this.attribute.set(attribute, value); };
    ElementEx.prototype.getAttribute = function(attribute)        { return this.attribute.get(attribute); };

    // Fallback to old KrupaBOX versions
    ElementEx.prototype.getStyle = function(key)
    {
        if (this.element == null) return null;
        return window.jQueryKB(this.element).css(key);
    };

    // Fallback to old KrupaBOX versions
    ElementEx.prototype.setStyle = function(key, value)
    {
        if (this.element == null) return null;
        window.jQueryKB(this.element).css(key, value);
    };

    ElementEx.prototype.getChildrens = function()
    {
        if (this.element == null) return null;

        var childrens = window.jQueryKB(this.element).children();
        if (childrens.length <= 0) return null;

        var elements = new Elements();
        for (var i = 0; i < childrens.length; i++)
            elements.add(new ElementEx(childrens[i]));
        return elements;
    };

})(window);
