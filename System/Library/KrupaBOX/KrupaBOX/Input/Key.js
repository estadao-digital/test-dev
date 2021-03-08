(function(window) {

    window.Input = (window.Input || {});
    Input.Key = {};

    Input.Key.__keys__     = Arr();
    Input.Key.__keyCodes__ = Arr();

    Input.Key.isKeyCodeDown = function (keyCode)
    {
        if (keyCode == null || keyCode == undefined)
            return null;
        keyCode = toInt(keyCode);

        if (Input.Key.__keyCodes__.containsKey(keyCode) == false)
            return false;
        return (Input.Key.__keyCodes__[keyCode].isDown == true);
    };

    Input.Key.isKeyCodeUp = function (keyCode)
    {
        if (keyCode == null || keyCode == undefined)
            return null;
        keyCode = toInt(keyCode);

        if (Input.Key.__keyCodes__.containsKey(keyCode) == false)
            return true;
        return (Input.Key.__keyCodes__[keyCode].isDown == false);
    };

    Input.Key.isKeyDown = function (key)
    {
        if (key == null || key == undefined)
            return null;
        key = toString(key);

        if (Input.Key.__keys__.containsKey(key) == false)
            return false;

        var isDown = false;
        for (var i = 0; i < Input.Key.__keys__[key].length; i++)
            if (Input.Key.isKeyCodeDown(Input.Key.__keys__[key][i]) == true)
            { isDown = true; break; }
        return isDown;
    };

    Input.Key.isKeyUp = function (key)
    {
        if (key == null || key == undefined)
            return null;
        key = toString(key);

        if (Input.Key.__keys__.containsKey(key) == false)
            return true;

        var isUp = true;
        for (var i = 0; i < Input.Key.__keys__[key].length; i++)
            if (Input.Key.isKeyCodeDown(Input.Key.__keys__[key][i]) == true)
            { isUp = false; break; }
        return isUp;
    };

})(window);
