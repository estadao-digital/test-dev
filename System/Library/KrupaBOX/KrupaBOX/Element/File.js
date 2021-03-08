(function(window) {

    window.ElementEx = (window.ElementEx || {});

    ElementEx.File = function(elementEx) {
        this.elementEx = null;

        this.constructor = function(elementEx)
        { this.elementEx = elementEx; this.__defineProperties__();  };

        this.constructor(elementEx);
        return this;
    };

    ElementEx.File.prototype.clean = function ()
    {
        if (this.elementEx.element == null) return null;
        this.elementEx.jQueryKB.val("");
    };

    ElementEx.File.prototype.getFiles = function ()
    {
        if (this.elementEx.element == null) return null;

        var files = null;
        try { files = this.elementEx.element.files; } catch (exception) {};

        var cleanFiles = Arr();
        if (files == null) return cleanFiles;

        for (var i = 0; i < files.length; i++)
            cleanFiles.add(files[i]);
        return cleanFiles;
    };

    ElementEx.File.prototype.getList = function ()
    { return this.getFiles(); };

    ElementEx.File.prototype.__defineProperties__ = function()
    {
        Object.defineProperty(this, "files", {
            get: function () { return this.getFiles(); }
        });
    };

})(window);
