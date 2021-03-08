
(function(window) {

    window.Input    = (window.Input || {});

    Input.Gyroscope = {};

    Input.Gyroscope.getGyroscope = function(delegate)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        var protocol = Connection.getProtocol();
        if (protocol != "https")
        {
            var data = Arr();
            data.error = "PROTOCOL_NOT_HTTPS";
            delegate(data, false);
            return null;
        }

        if (window.GyroNormKB === null || window.GyroNormKB === undefined) {
            console.error("KrupaBOX: Please, enable frontend gyroscope in config->front->support->gyroscope.");

            var data = Arr();
            data.error = "BROWSER_DONT_SUPPORT_GYROSCOPE";
            delegate(data, false);
            return null;
        }

        var gyronorm = new GyroNormKB();
        gyronorm.init().then(function()
        {
            var notAvailableCount = 0;
            var isAvailable = gyronorm.isAvailable();
            if(!isAvailable.deviceOrientationAvailable)
                notAvailableCount++;
            if(!isAvailable.accelerationAvailable)
                notAvailableCount++;
            if(!isAvailable.accelerationIncludingGravityAvailable)
                notAvailableCount++;
            if(!isAvailable.rotationRateAvailable)
                notAvailableCount++;

            if (notAvailableCount >= 4)
            {
                var data = Arr();
                data.error = "BROWSER_DONT_SUPPORT_GYROSCOPE";
                delegate(data, false);
                return null;
            }

            gyronorm.start(function(_data)
            {
                var data = Arr();
                data.gravity      = null;
                data.rotationRate = null;

                if (_data !== null && _data !== undefined)
                {
                    if (_data.dm.gx !== null && _data.dm.gx !== undefined)
                    {
                        data.gravity = Arr();
                        data.gravity.x = _data.dm.gx;
                        data.gravity.y = _data.dm.gy;
                        data.gravity.z = _data.dm.gz;

                        data.gravity.x = data.gravity.x.toFloat();
                        data.gravity.y = data.gravity.y.toFloat();
                        data.gravity.z = data.gravity.z.toFloat();
                    }
                    if (_data.dm.alpha !== null && _data.dm.alpha !== undefined)
                    {
                        data.rotationRate = Arr();
                        data.rotationRate.x = _data.dm.alpha;
                        data.rotationRate.y = _data.dm.beta;
                        data.rotationRate.z = _data.dm.gamma;

                        data.rotationRate.x = data.rotationRate.x.toFloat();
                        data.rotationRate.y = data.rotationRate.y.toFloat();
                        data.rotationRate.z = data.rotationRate.z.toFloat();
                    }
                }

                delegate(data, true);
                return null;
            });

        }).catch(function(e){ console.log(e); });
    };

})(window);