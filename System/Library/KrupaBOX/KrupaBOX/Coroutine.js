(function(window)
{
    window.Coroutine = function(delegate, delay, autoStart)
    {
        this.delegate  = null;
        this.isRunning = false;

        this.constructor = function(delegate, autoStart, delay)
        {
            if (FunctionEx.isFunction(delegate) == false)
                return null;

            delay = toFloat(delay);

            if (autoStart == null || autoStart == undefined)
                autoStart = false;

            this.delegate = delegate;

            if (autoStart == true)
            {
                if (delay == 0)
                    this.start();
                else {
                    this.isRunning = true;
                    var myThis = this;
                    window.setTimeout(function() {
                        myThis.__callDelegate__();
                    }, delay);
                }
            }
        };

        this.start = function()
        {
            if (this.isRunning == true)
                return null;

            this.isRunning = true;
            this.__callDelegate__();
        };

        this.stop = function()
        { this.isRunning = false; };

        this.__callDelegate__ = function()
        {
            if (this.isRunning == false)
                return null;

            var _return = null;
            try { _return = this.delegate();  }
            catch(err) { console.error(err);  }

            if (_return != null && _return != undefined)
            {
                if (_return instanceof WaitForSeconds)
                    _return = _return.toMiliseconds();

                if (_return instanceof WaitForMiliseconds)
                {
                    var myThis = this;
                    window.setTimeout(function() {
                        myThis.__callDelegate__();
                    }, _return.miliseconds);

                    return null;
                }
            }

            this.stop();
        };

        this.constructor(delegate, delay, autoStart);
        return this;
    };

})(window);
