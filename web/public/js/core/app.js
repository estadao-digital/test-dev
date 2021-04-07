const App = function () {
    const include = function (file) {
        const script = document.createElement('script')
        
        script.src = file
        script.type = 'text/javascript'
        script.defer = true
        
        document.getElementsByTagName('head').item(0).appendChild(script)
    }

    include('js/core/load.js')

    return {
        include: function (file) {
            return include(file)
        }
    }
}()