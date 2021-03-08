(function(window) {

    window.Input = (window.Input || {});
    Input.Cookie = {};

    Input.Cookie.get = function(key, type)
    {
        if (type == null || type == undefined)
            type = "string";

        var name = key + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return Input.Cookie.__getParse__(c.substring(name.length, c.length), type);
            }
        }

        return Input.Cookie.__getParse__("", type);
    };

    Input.Cookie.__getParse__ = function(value, type)
    {
        if (type == "string" || type == string || type == stringEx)
            return stringEx(value).toString();
        else if (type == "int" || type == int || type == intEx)
            return intEx(value).toInt();
        return stringEx(value).toString();
    };

    Input.Cookie.set = function(key, value, expire, domain, path)
    {
        key    = ((key == null || key == undefined)       ? "" : stringEx(key).toString());
        value  = ((value == null || value == undefined)   ? "" : stringEx(value).toString());
        expire = ((expire == null || expire == undefined) ? -1 : intEx(expire).toInt());
        domain = ((domain == null || domain == undefined) ? "" : stringEx(domain).toString());
        path   = ((path == null || path == undefined)     ? "/" : stringEx(path).toString());

        if (expire > 0) {
            var date = new Date();
            date.setTime(date.getTime() + expire);
            expire = date.toUTCString();
        } else expire = expire.toString();

        document.cookie = (key + "=" + (value || "") + "; expires=" + expire + "; path=" + path);
    }

})(window);
