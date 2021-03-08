(function(window) {

    window.Browser = (window.Browser || {});
    Browser.PopUp = {};

    Browser.PopUp.open = function(url, title, width, height)
    {
        if (url == undefined)
            url = null;

        url   = stringEx(url).toString();
        title = stringEx(title).toString();

        if (stringEx(url).isEmpty())
            return null;

        var w = intEx(width).toInt();
        var h = intEx(height).toInt();
        if (w == 0) w = 800;
        if (h == 0) h = 600;

        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus)
            newWindow.focus();
        return newWindow;
    };

    Browser.PopUp.openTab = function(url)
    {
        var newWindow = window.open(url, '_blank');
        if (window.focus)
            newWindow.focus();
    };

})(window);
