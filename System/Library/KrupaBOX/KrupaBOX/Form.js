(function(window) {

    window.Form = function(value)
    {
        this.formElement = null;
    };

    Form.find = function(searchQuery)
    {
        var _form = Element.find(searchQuery);

        if (_form != null)
        {
            var form = new Form();
            form.formElement = _form;
            return form;
        }

        return null;
    };

    Form.prototype.getInputs = function()
    {
        var dataInputs = Arr();

        var inputs = this.formElement.find("[data-input]", true);
        if (inputs == null || inputs.length <= 0)
            return dataInputs;

        for (var i = 0; i < inputs.elements.length; i++)
        {
            var _value = inputs.elements[i].get("value");
            if (_value == null || _value == undefined)
                _value = "";

            dataInputs[(inputs.elements[i].get("data-input"))] = ({
                value: _value,
                element: inputs.elements[i]
            });
        }

        return dataInputs;
    };

    Form.prototype.clearInputs = function(includeHidden)
    {
        var dataInputs = Arr();

        var inputs = this.formElement.find("[data-input]", true);
        if (inputs == null || inputs.length <= 0)
            return dataInputs;

        if (includeHidden === null || includeHidden === undefined)
            includeHidden = false;

        for (var key in inputs)
            if (inputs.containsKey(key) && (includeHidden == false || input[key].get("type") != "hidden"))
                inputs[key].set("value", "");

        return true;
    };

    Form.prototype.getSubmitButton = function()
    {
        return this.formElement.find("[data-action='submit']");
    };

    Form.prototype.onSubmit = function(delegate)
    {
        if (typeOf(delegate) != "function")
            return null;

        var submitButton = this.getSubmitButton();
        if (submitButton == null) return null;

        var form = this;
        submitButton.onClick(function(event){
            event.preventDefault();
            return delegate(form);
        });
    };

})(window);
