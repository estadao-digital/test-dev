const Load = function () {

    const files = [
        'js/core/events.js'
    ]

    files.map(function (file) {
        App.include(file)
    })
}()