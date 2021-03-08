(function(window)
{
    window.Screenshot = {};

    Screenshot.getBase64 = function(delegate)
    { return Screenshot.getBase64ByElement(Element.find("html"), delegate); }

    Screenshot.getBase64ByElement = function(element, delegate)
    {
        if (window.html2canvasKB === null || window.html2canvasKB === undefined) {
            console.error("KrupaBOX: Please, enable frontend screenshot in config->front->support->screenshot.");
            return null;
        }

        if (FunctionEx.isFunction(delegate) == false)
            return null;

        var element = Element.find(element);

        html2canvasKB(element.element).then(function(canvas) {
            var base64 = canvas.toDataURL();
            delegate(base64);
        });
    }

})(window);