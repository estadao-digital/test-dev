(function(window) {

    if (File === null || File === undefined)
        return null;

    File.prototype.readAllDataUrl = function (delegate)
    {
        if (this.fileReader == null)
            this.fileReader = new FileReader();

        var _fileReader = this.fileReader;
        this.fileReader.addEventListener("load", function () {
            if (typeOf(delegate) == "function")
                delegate(_fileReader.result, _fileReader.error);
        }, false);

        this.fileReader.readAsDataURL(this);
        return true;
    };

    File.prototype.readAllDataURL = File.prototype.readAllDataUrl;

})(window);