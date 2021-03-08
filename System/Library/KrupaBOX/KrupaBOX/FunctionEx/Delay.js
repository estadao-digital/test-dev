(function(window)
{
    window.FunctionEx = (window.FunctionEx || {});

    FunctionEx.Delay = (function(delegate, delay, params)
    {
        this.delegate  = null;
        this.isRunning = false;

        this.constructor = function(delegate, delay, params)
        {
            if (FunctionEx.isFunction(delegate) == false)
                return null;

            delay = toFloat(delay);
            if (delay <= 0) delay = 1;

            this.delegate  = delegate;
            this.isRunning = true;

            var myThis = this;
            window.setTimeout(function(params) {
                myThis.__callDelegate__(params);
            }, delay, params);
        };

        this.__callDelegate__ = function(params)
        {
            if (this.isRunning == false)
                return null;

            try { this.delegate(params);  }
            catch(err) { console.error(err);  }
        };

        this.stop = function()
        { this.isRunning = false;  };

        this.constructor(delegate, delay, params);
    });

})(window);