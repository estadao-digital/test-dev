(function(window) {

    window.WebGL = (window.WebGL || {});

    WebGL.isSupported = function()
    {
        if (WebGL.WebGLRenderer === undefined)
            return false;

        return true;
    };

    WebGL.Renderer = function(data)
    {
        if (WebGL.WebGLRenderer === undefined)
        {
            console.error("KrupaBOX: Please, enable frontend webgl in config->front->support->webgl.");
            return null;
        }

        return WebGL.WebGLRenderer(data);
    };

})(window);
