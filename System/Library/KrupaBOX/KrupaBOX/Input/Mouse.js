(function(window) {

    window.Input = (window.Input || {});
    Input.Mouse = {};

    Input.Mouse.__currentPosition__ = Vector2.zero();

    Input.Mouse.BUTTON_LEFT   = "left";
    Input.Mouse.BUTTON_MIDDLE = "middle";
    Input.Mouse.BUTTON_RIGHT  = "right";

    Input.Mouse.getPosition = function()
    { return Input.Mouse.__currentPosition__; };

})(window);
