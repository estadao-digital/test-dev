(function(window) {

    window.JavaScript = window;

    JavaScript.fromJS = function(code)
    {
        var returned = null;
        try { returned = eval(code); } catch (e) {}
        return returned;
    };

    JavaScript.getVersion = function()
    {
        var major = JavaScript.getMajorVersion();
        if (major == null) return null;
        var minor = JavaScript.getMinorVersion();
        if (minor == null) minor = 0;
        return (major + "." + minor);
    };

    JavaScript.getMajorVersion = function()
    {
        var version = JavaScript.__getVersion__();
        if (version == null) return version;
        version = stringEx(version).toString();
        var split = version.split(".");
        return intEx(split[0]).toInt();
    };

    JavaScript.getMinorVersion = function()
    {
        var version = JavaScript.__getVersion__();
        if (version == null) return version;
        version = stringEx(version).toString();
        var split = version.split(".");
        return intEx(split[1]).toInt();
    };

    JavaScript.__version__    = null;
    JavaScript.__getVersion__ = function()
    {
        if (JavaScript.__version__ != null)
            return JavaScript.__version__;

        var agt=navigator.userAgent.toLowerCase();
        var is_major = parseInt(navigator.appVersion);
        var is_minor = parseFloat(navigator.appVersion);
        var is_nav  = ((agt.indexOf('mozilla')!=-1) && (agt.indexOf('spoofer')==-1)
        && (agt.indexOf('compatible') == -1) && (agt.indexOf('opera')==-1)
        && (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1));
        var is_nav2 = (is_nav && (is_major == 2));
        var is_nav3 = (is_nav && (is_major == 3));
        var is_nav4 = (is_nav && (is_major == 4));
        var is_nav4up = (is_nav && (is_major >= 4));
        var is_navonly = (is_nav && ((agt.indexOf(";nav") != -1) ||
        (agt.indexOf("; nav") != -1)) );
        var is_nav6 = (is_nav && (is_major == 5));
        var is_nav6up = (is_nav && (is_major >= 5));
        var is_gecko = (agt.indexOf('gecko') != -1);
        var is_ie     = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
        var is_ie3    = (is_ie && (is_major < 4));
        var is_ie4    = (is_ie && (is_major == 4) && (agt.indexOf("msie 4")!=-1) );
        var is_ie4up  = (is_ie && (is_major >= 4));
        var is_ie5    = (is_ie && (is_major == 4) && (agt.indexOf("msie 5.0")!=-1) );
        var is_ie5_5  = (is_ie && (is_major == 4) && (agt.indexOf("msie 5.5") !=-1));
        var is_ie5up  = (is_ie && !is_ie3 && !is_ie4);
        var is_ie5_5up =(is_ie && !is_ie3 && !is_ie4 && !is_ie5);
        var is_ie6    = (is_ie && (is_major == 4) && (agt.indexOf("msie 6.")!=-1) );
        var is_ie6up  = (is_ie && !is_ie3 && !is_ie4 && !is_ie5 && !is_ie5_5);
        var is_aol   = (agt.indexOf("aol") != -1);
        var is_aol3  = (is_aol && is_ie3);
        var is_aol4  = (is_aol && is_ie4);
        var is_aol5  = (agt.indexOf("aol 5") != -1);
        var is_aol6  = (agt.indexOf("aol 6") != -1);
        var is_opera = (agt.indexOf("opera") != -1);
        var is_opera2 = (agt.indexOf("opera 2") != -1 || agt.indexOf("opera/2") != -1);
        var is_opera3 = (agt.indexOf("opera 3") != -1 || agt.indexOf("opera/3") != -1);
        var is_opera4 = (agt.indexOf("opera 4") != -1 || agt.indexOf("opera/4") != -1);
        var is_opera5 = (agt.indexOf("opera 5") != -1 || agt.indexOf("opera/5") != -1);
        var is_opera5up = (is_opera && !is_opera2 && !is_opera3 && !is_opera4);
        var is_webtv = (agt.indexOf("webtv") != -1);
        var is_TVNavigator = ((agt.indexOf("navio") != -1) || (agt.indexOf("navio_aoltv") != -1));
        var is_AOLTV = is_TVNavigator;
        var is_hotjava = (agt.indexOf("hotjava") != -1);
        var is_hotjava3 = (is_hotjava && (is_major == 3));
        var is_hotjava3up = (is_hotjava && (is_major >= 3));
        var is_js;
        if (is_nav2 || is_ie3) is_js = 1.0;
        else if (is_nav3) is_js = 1.1;
        else if (is_opera5up) is_js = 1.3;
        else if (is_opera) is_js = 1.1;
        else if ((is_nav4 && (is_minor <= 4.05)) || is_ie4) is_js = 1.2;
        else if ((is_nav4 && (is_minor > 4.05)) || is_ie5) is_js = 1.3;
        else if (is_hotjava3up) is_js = 1.4;
        else if (is_nav6 || is_gecko) is_js = 1.5;
        else if (is_nav6up) is_js = 1.5;
        else if (is_ie5up) is_js = 1.3;
        else is_js = null;
        JavaScript.__version__ = is_js;
        return (is_js) ;
    }

})(window);
