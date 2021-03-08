(function(window) {

    window.Render = (window.Render || {});

    function Front() {
        this.renderHTML = function (html, data) {
            renderData = Arr(data);

            if (html === null || html === undefined)
                html = "";

            html = this.__prepareHTML__(html);

            if (window.TwigKB === null || window.TwigKB === undefined) {
                console.error("KrupaBOX: Please, enable frontend render in config->front->support->render.");
                return html;
            }

            var template = TwigKB.twig({ data: html });
            return template.render(renderData);
        };

        this.__prepareHTML__ = function(html)
        {
            return html;
        }
    }

    Render.Front = new Front();
    window.Render__Front = Render.Front;
})(window);


