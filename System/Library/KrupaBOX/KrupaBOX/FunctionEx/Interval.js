(function(window)
{
    window.FunctionEx = (window.FunctionEx || {});

    FunctionEx.Interval = (function(delegate, delay)
    {
        this.delegate  = null;
        this.isRunning = false;

        this.constructor = function(delegate, delay)
        {
            if (FunctionEx.isFunction(delegate) == false)
                return null;

            delay = toFloat(delay);
            if (delay <= 0) delay = 1;

            this.delegate  = delegate;
            this.isRunning = true;

            var myThis = this;
            window.setTimeout(function() {
                myThis.__callDelegate__();
            }, delay);
        };

        this.__callDelegate__ = function()
        {
            if (this.isRunning == false)
                return null;

            var _return = null;
            try { _return = this.delegate();  }
            catch(err) { console.error(err);  }

            if (_return === false) {
                this.stop();
                return null;
            }

            var myThis = this;
            window.setTimeout(function() {
                myThis.__callDelegate__();
            }, delay);
        };

        this.stop = function()
        { this.isRunning = false;  };

        this.constructor(delegate, delay);
    });

})(window);