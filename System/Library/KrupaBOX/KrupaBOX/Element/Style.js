(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.Style = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; this.__defineProperties__();  };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.Style.prototype.set = function (key, value)
    {
        if (this.elementEx.element == null) return null;
        key = String(key).toString();
        this.elementEx.jQueryKB.css(key, value);
    };

    ElementEx.Style.prototype.add = function (key, value)
    { return this.set(key, value); };

    ElementEx.Style.prototype.get = function (key)
    {
        if (this.elementEx.element == null) return null;
        key = String(key).toString();
        return this.elementEx.jQueryKB.css(key);
    };

    ElementEx.Style.prototype.remove = function (key)
    {
        if (this.elementEx.element == null) return null;
        key = String(key).toString();
        this.elementEx.jQueryKB.css(key, "");
    };

    ElementEx.Style.prototype.getStyles = function ()
    {
        if (this.elementEx.element == null) return null;
        ElementEx.Style.__hookStyleList__();

        var styles = Arr();
        for (i = 0; i < ElementEx.Style.__styleList__.length; i++) {
            var key   = ElementEx.Style.__styleList__[i];
            var value = this.get(key);
            if (value != null && value != "" && (typeof value != "function") &&
                value != "0px" && value != "normal" && value != "0s" &&
                value != "none" && value != "auto" && value != "0%")
                styles[key] = value;
        }

        if (this.elementEx.element.style != null) {
            for (i = 0; i < this.elementEx.element.style.length; i++) {
                var key   = this.elementEx.element.style[i];
                styles[key] = value;
            }
        }

        return styles;
    };

    ElementEx.Style.prototype.getList = function ()
    { return this.getStyles(); };

    ElementEx.Style.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "styles", {
            get: function () { return this.getStyles(); }
        });
    };

    ElementEx.Style.__hookStyleList__ = function()
    {
        if (ElementEx.Style.__styleList__ != null) return null;
        ElementEx.Style.__styleList__ = Arr();

        // Get properties list
        var _html = Element.find("html");
        if (_html != null && _html.element.style != null) {
            var _styles = _html.element.style;
            for (var key in _styles)
                if (key != "item" && key != "getPropertyValue" && key != "getPropertyPriority" && key != "setProperty" && key != "removeProperty")
                    ElementEx.Style.__styleList__.add(key);
        } else { ElementEx.Style.__styleList__ = Arr(["alignContent", "alignItems", "alignSelf", "alignmentBaseline", "all", "animation", "animationDelay", "animationDirection", "animationDuration", "animationFillMode", "animationIterationCount", "animationName", "animationPlayState", "animationTimingFunction", "backfaceVisibility", "background", "backgroundAttachment", "backgroundBlendMode", "backgroundClip", "backgroundColor", "backgroundImage", "backgroundOrigin", "backgroundPosition", "backgroundPositionX", "backgroundPositionY", "backgroundRepeat", "backgroundRepeatX", "backgroundRepeatY", "backgroundSize", "baselineShift", "blockSize", "border", "borderBottom", "borderBottomColor", "borderBottomLeftRadius", "borderBottomRightRadius", "borderBottomStyle", "borderBottomWidth", "borderCollapse", "borderColor", "borderImage", "borderImageOutset", "borderImageRepeat", "borderImageSlice", "borderImageSource", "borderImageWidth", "borderLeft", "borderLeftColor", "borderLeftStyle", "borderLeftWidth", "borderRadius", "borderRight", "borderRightColor", "borderRightStyle", "borderRightWidth", "borderSpacing", "borderStyle", "borderTop", "borderTopColor", "borderTopLeftRadius", "borderTopRightRadius", "borderTopStyle", "borderTopWidth", "borderWidth", "bottom", "boxShadow", "boxSizing", "breakAfter", "breakBefore", "breakInside", "bufferedRendering", "captionSide", "caretColor", "clear", "clip", "clipPath", "clipRule", "color", "colorInterpolation", "colorInterpolationFilters", "colorRendering", "columnCount", "columnFill", "columnGap", "columnRule", "columnRuleColor", "columnRuleStyle", "columnRuleWidth", "columnSpan", "columnWidth", "columns", "contain", "content", "counterIncrement", "counterReset", "cursor", "cx", "cy", "d", "direction", "display", "dominantBaseline", "emptyCells", "fill", "fillOpacity", "fillRule", "filter", "flex", "flexBasis", "flexDirection", "flexFlow", "flexGrow", "flexShrink", "flexWrap", "float", "floodColor", "floodOpacity", "font", "fontDisplay", "fontFamily", "fontFeatureSettings", "fontKerning", "fontSize", "fontStretch", "fontStyle", "fontVariant", "fontVariantCaps", "fontVariantEastAsian", "fontVariantLigatures", "fontVariantNumeric", "fontVariationSettings", "fontWeight", "grid", "gridArea", "gridAutoColumns", "gridAutoFlow", "gridAutoRows", "gridColumn", "gridColumnEnd", "gridColumnGap", "gridColumnStart", "gridGap", "gridRow", "gridRowEnd", "gridRowGap", "gridRowStart", "gridTemplate", "gridTemplateAreas", "gridTemplateColumns", "gridTemplateRows", "height", "hyphens", "imageRendering", "inlineSize", "isolation", "justifyContent", "justifyItems", "justifySelf", "left", "letterSpacing", "lightingColor", "lineBreak", "lineHeight", "listStyle", "listStyleImage", "listStylePosition", "listStyleType", "margin", "marginBottom", "marginLeft", "marginRight", "marginTop", "marker", "markerEnd", "markerMid", "markerStart", "mask", "maskType", "maxBlockSize", "maxHeight", "maxInlineSize", "maxWidth", "maxZoom", "minBlockSize", "minHeight", "minInlineSize", "minWidth", "minZoom", "mixBlendMode", "objectFit", "objectPosition", "offset", "offsetDistance", "offsetPath", "offsetRotate", "opacity", "order", "orientation", "orphans", "outline", "outlineColor", "outlineOffset", "outlineStyle", "outlineWidth", "overflow", "overflowAnchor", "overflowWrap", "overflowX", "overflowY", "overscrollBehavior", "overscrollBehaviorX", "overscrollBehaviorY", "padding", "paddingBottom", "paddingLeft", "paddingRight", "paddingTop", "page", "pageBreakAfter", "pageBreakBefore", "pageBreakInside", "paintOrder", "perspective", "perspectiveOrigin", "placeContent", "placeItems", "placeSelf", "pointerEvents", "position", "quotes", "r", "resize", "right", "rx", "ry", "scrollBehavior", "shapeImageThreshold", "shapeMargin", "shapeOutside", "shapeRendering", "size", "speak", "src", "stopColor", "stopOpacity", "stroke", "strokeDasharray", "strokeDashoffset", "strokeLinecap", "strokeLinejoin", "strokeMiterlimit", "strokeOpacity", "strokeWidth", "tabSize", "tableLayout", "textAlign", "textAlignLast", "textAnchor", "textCombineUpright", "textDecoration", "textDecorationColor", "textDecorationLine", "textDecorationSkipInk", "textDecorationStyle", "textIndent", "textOrientation", "textOverflow", "textRendering", "textShadow", "textSizeAdjust", "textTransform", "textUnderlinePosition", "top", "touchAction", "transform", "transformBox", "transformOrigin", "transformStyle", "transition", "transitionDelay", "transitionDuration", "transitionProperty", "transitionTimingFunction", "unicodeBidi", "unicodeRange", "userSelect", "userZoom", "vectorEffect", "verticalAlign", "visibility", "whiteSpace", "widows", "width", "willChange", "wordBreak", "wordSpacing", "wordWrap", "writingMode", "x", "y", "zIndex", "zoom", "cssText", "length", "parentRule", "cssFloat"]); }
    }

})(window);
