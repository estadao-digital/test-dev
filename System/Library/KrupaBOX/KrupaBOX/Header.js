(function(window) {

    function Header()
    {
        this.redirect = function (url)
        {
            Header.__redirectUrl__ = url;
            Header.__executeRedirect__(url);
            window.setTimeout(function() { Header.__executeRedirect__(url); }, 10); // Cause form block redirect
            return false;
        };

        this.redirectAsync = function(url, timeout)
        {
            if (Internal.PostProcess.AsyncHref.isExecuting == true)
                return null;
            Internal.PostProcess.AsyncHref.isExecuting = true;
            
            timeout = intEx(timeout).toInt();
            Internal.PostProcess.AsyncHref.callByUrlAndTimeout(url, timeout);
            return false;
        };

        this.refresh = function()
        {
            location.reload();
            history.go(0);
            var href = location.href;
            location.href = href;
            location.href = location.pathname;
            location.replace(location.pathname);
            location.reload(false);
        };
    }

    window.Header = new Header();

    Header.__redirectUrl__ = null;
    Header.__executeRedirect__ = function(url)
    {
        // Default redirect system
        window.location.href = url;

        // Fallback to http equiv
        var head = Element.find("head");
        if (head != null) head.appendHTML("<meta http-equiv=\"refresh\" content=\"0; url=" + url + "\"/>");

        // // Fallback redirect by click
        var body = Element.find("body");
        if (body != null) body.appendHTML("<a id=\"kbox-redirect\" href=\"" + url + "\"></a>");
        var redirectClick = Element.find("#kbox-redirect");
        if (redirectClick != null) redirectClick.click();
    }

})(window);