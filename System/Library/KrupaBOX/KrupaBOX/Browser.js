(function(window)
{
    window.Browser = {};

    Browser.__hash__ = null;

    Browser.getResolution = function()
    {
        var _jquery = window.jQueryKB;
        var resolution = Arr();
        resolution.width  = intEx(_jquery(window).width());
        resolution.height =  intEx(_jquery(window).height());
        return resolution;
    };

    Browser.getHash = function() {
        if (Browser.__hash__ != null)
            return Browser.__hash__;
        Browser.__hash__ = PostProcess.data.global.browser.hash;
        return Browser.__hash__;
    };

    Browser.isBrowser = function()
    { return true; };

    Browser.isMobile = function()
    { return PostProcess.data.global.browser.isMobile; };

    Browser.getPlatform = function()
    { return PostProcess.data.global.browser.platform; };

    Browser.getPlatformName = function()
    { return PostProcess.data.global.browser.platformName; };

    Browser.getBrowser = function()
    { return PostProcess.data.global.browser.browser; };

    Browser.getBrowserVersion = function(returnNumber)
    {
        if (returnNumber === null || returnNumber == undefined)
            returnNumber = true;

        if (returnNumber == true)
            return PostProcess.data.global.browser.browserVersionNumber;
        return PostProcess.data.global.browser.browserVersion;
    };

    Browser.support = function(support, ignoreEmulated)
    {
        if (window.ModernizrKB === null || window.ModernizrKB === undefined) {
            console.error("KrupaBOX: Please, enable frontend validate in config->front->support->validate.");
            return null;
        }

        var isSupported = ModernizrKB[support];
        if (isSupported == undefined || isSupported == null)
            return null;
        return isSupported;
    };

    Browser.getScreenshotImage = function()
    { return Screenshot.getImage(); }

})(window);