

(function(window) {

    window.Render = (window.Render || {});
    window.Render.Front = (window.Render.Front || {});

    function Template() {
        this.templates = [];

        this.find = function (sid)
        {
            if (this.templates[sid] != undefined && this.templates[sid] != null)
                return this.templates[sid];
            var element = null;
            try { element = Element.find("[app-template='" + sid + "']"); } catch (e) {}

            if (element == null) return null;
            var templateHtml = urldecode(element.html);
            element.destroy();
            this.templates[sid] = templateHtml;
            return templateHtml;
        };
        this.getBySid = function (sid) { return this.find(sid); }
    }

    Render.Front.Template = new Template();
    window.Render__Front__Template = Render.Front.Template;
})(window);


