(function(window)
{
    window.Clipboard = {};

    Clipboard.setByString = function(value)
    { return Clipboard.set(value); };

    Clipboard.set = function(value)
    {
        if (window.document === null || window.document === undefined ||
            window.document.execCommand === null || window.document.execCommand === undefined)
            return null;

        var body = jQueryKB("body");
        body.append("<textarea id=\"krupabox-clipboard-hook\">test</textarea>");

        var textareaHook = jQueryKB("#krupabox-clipboard-hook");
        textareaHook.css("position", "absolute");
        textareaHook.css("right", "-" + Browser.getResolution().width.toString() + "px");
        textareaHook.val(value);
        textareaHook.select();

        var _return = window.document.execCommand('copy');
        textareaHook.remove();

        return _return;
    };

})(window);