(function(window)
{
    window.WaitForMiliseconds = function(miliseconds)
    {
        this.miliseconds = 0;

        this.constructor = function(miliseconds)
        { this.miliseconds = toInt(miliseconds); };

        this.toSeconds = function()
        { return new WaitForSeconds(toFloat(miliseconds / 1000)); };

        this.constructor(miliseconds);
        return this;
    };

})(window);
