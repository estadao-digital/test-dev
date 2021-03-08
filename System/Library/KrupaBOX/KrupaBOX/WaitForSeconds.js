(function(window)
{
    window.WaitForSeconds = function(seconds)
    {
        this.seconds = 0;

        this.constructor = function(seconds)
        { this.seconds = toFloat(seconds); };

        this.toMiliseconds = function()
        { return new WaitForMiliseconds(toFloat(seconds * 1000)); };

        this.constructor(seconds);
        return this;
    };

})(window);
