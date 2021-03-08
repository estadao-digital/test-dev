(function(window) {

    function Input() {
        this.get = function (parameters) {
            var values = this.__getValues.get;
            var parametersValues = {};

            for (var key in parameters) {
                parametersValues[key] = "";

                if (values[key] != null)
                    parametersValues[key] = values[key];

                parametersValues[key] = parametersValues[key].toString();

                if (parameters[key] == int || parameters[key] == "int")
                    parametersValues[key] = parametersValues[key].toInt();
                else if (parameters[key] == float || parameters[key] == "float")
                    parametersValues[key] = parametersValues[key].toFloat();
                else if (parameters[key] == bool || parameters[key] == "bool")
                    parametersValues[key] = parametersValues[key].toBool();
            }

            return parametersValues;
        };

        this.__getValues = {
            get get() {
                var vars = {};
                if (window.location.search.length !== 0)
                    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
                        key = decodeURIComponent(key);
                        if (typeof vars[key] === "undefined")
                            vars[key] = decodeURIComponent(value);
                        else vars[key] = [].concat(vars[key], decodeURIComponent(value));
                    });
                return vars;
            }
        };
    }

    window.Input = new Input();

})(window);