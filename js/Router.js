let Router = {

    _param: null,

    to: (component, param = null) => {

        (param) ? Router._param = param : Router._param = null;

        $.ajax({
            url: `app/${component}.html`,
            success: (response) => {
                $('main').html(response);
            }
        })
    },

    getParams: () => {
        return Router._param;
    },

};