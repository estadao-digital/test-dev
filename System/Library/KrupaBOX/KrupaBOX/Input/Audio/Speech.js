(function(window) {

    window.Input = (window.Input || {});
    Input.Audio = (window.Input.Audio || {});
    Input.Audio.Speech = {};

    Input.Audio.Speech.__isInitialized__ = false;

    Input.Audio.Speech.__initialize__ = function()
    {
        Input.Audio.Speech.__isInitialized__ = true;
        annyangKB.addCallback("result", Input.Audio.Speech.__onResult__);

    };

    Input.Audio.Speech.__delegate__ = null;

    Input.Audio.Speech.start = function()
    {
        if (Input.Audio.Speech.__isInitialized__ == false)
            Input.Audio.Speech.__initialize__();

        annyangKB.start({ autoRestart: true, continuous: true });
    };

    Input.Audio.Speech.stop = function()
    {
        annyangKB.abort();
    };

    Input.Audio.Speech.setLanguageISO = function (iso)
    {
        Input.Audio.Speech.stop();
        annyangKB.setLanguage(iso);
        Input.Audio.Speech.start();
    };

    Input.Audio.Speech.__onResult__ = function(results)
    {
        var _results = Arr(results);
        var trimResults = Arr();

        for (var i = 0; i < _results.count; i++)
            trimResults.add(_results[i].trim());
        if (trimResults.count <= 0)
            trimResults = null;

        if (Input.Audio.Speech.__delegate__ !== null && Input.Audio.Speech.__delegate__ !== undefined)
            Input.Audio.Speech.__delegate__(trimResults, (trimResults != null));
    };

})(window);


