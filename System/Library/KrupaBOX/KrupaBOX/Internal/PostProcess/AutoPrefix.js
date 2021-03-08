(function(window) {
    var __PostProcess__AutoPrefix__ = function()
    {
        this.stylesheets = null;
        this.currentStylesheet = 0;
        this.currentRule       = 0;

        this.execute = function ()
        {
            if (window.pleeeaseKB === undefined || window.pleeeaseKB === null)
                    return null;

            if (document !== undefined && document !== null && document.styleSheets !== undefined && document.styleSheets !== null)
                this.stylesheets = document.styleSheets;
            this.asyncInjector();
        };

        this.asyncInjector = function()
        {
            if (this.stylesheets === undefined || this.stylesheets === null)
                return null;

            var stylesheet = this.stylesheets[this.currentStylesheet];
            if (stylesheet === null || stylesheet === undefined)
                return null;

            var rules = null;

            try { rules = stylesheet.cssRules; } catch (e) {}

            if (rules === undefined || rules === null)
                try { rules = stylesheet.rules; } catch (e) {}
            if (rules === undefined || rules === null)
            {
                this.currentStylesheet += 1;
                this.currentRule = 0;
                this.asyncInjector();
                return null;
            }

            var rule = rules[this.currentRule];
            if (rule === undefined || rule === null)
            {
                this.currentStylesheet += 1;
                this.currentRule = 0;
                this.asyncInjector();
                return null;
            }

            try {
                this.autoPrefixAlgr(rule.cssText);
                return null;

            } catch (e) {
                this.currentRule += 1;
                this.asyncInjector();
                return null;
            }
        };

        this.autoPrefixAlgr = function(cssText)
        {
            if (cssText.trim().startsWith("@"))
            {
                this.currentRule += 1;
                this.asyncInjector();
                return null;
            }

            window.pleeeaseKB.process(cssText, {
                "autoprefixer": { "browsers": [">1%", "last 2 versions", "Firefox ESR"] },
                "rem": { "rootValue": "16px" },
                "minifier": false,
                "import": false,
                "rebaseUrls": false
            }).then(function (result)
            {
                var myThis = Internal.PostProcess.AutoPrefix;
                var compiled = result.toString();

                var indexOfStart = compiled.indexOf("{");
                if (indexOfStart >= 0)
                {
                    compiled = compiled.subString(indexOfStart + 1);
                    compiled = compiled.subString(0, compiled.length - 1);
                    compiled = compiled.trim();

                    var stylesheet = myThis.stylesheets[myThis.currentStylesheet];
                    var rules = stylesheet.cssRules;
                    if (rules === undefined || rules === null)
                        rules = stylesheet.rules;

                    var rule = rules[myThis.currentRule];
                    rule.style.cssText = compiled;

                    myThis.currentRule += 1;
                    myThis.asyncInjector();
                    return null;
                }
            }).catch(function (err)
            {
                var myThis = Internal.PostProcess.AutoPrefix;
                myThis.currentRule += 1;
                myThis.asyncInjector();
                return null;
            });
        };
    };

    window.Internal = (window.Internal || {});
    window.Internal.PostProcess = (window.Internal.PostProcess || {});
    window.Internal.PostProcess.AutoPrefix = new __PostProcess__AutoPrefix__();
})(window);