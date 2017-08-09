var body = document.querySelector('body'),
    modals = document.querySelectorAll('.modal'),
    backdrops = document.querySelectorAll('.modal__backdrop'),
    scrollWindows = document.querySelectorAll('.modal__scroll-window');

function showModal(modalId) {
    var modal = document.querySelector('.modal--' + modalId);
    var backdrop = document.querySelector('.modal__backdrop--' + modalId);
    var scrollWindow = document.querySelector('.modal__scroll-window--' + modalId);

    body.style.overflow = "hidden";
    body.style.paddingLeft = "0";
    modal.style.visibility = "visible";

    backdrop.style.opacity = "0.8";
    backdrop.style.filter = "alpha(opacity=0.8)";

    scrollWindow.style.WebkitTransform = "scale(1,1)";
    scrollWindow.style.msTransform = "scale(1,1)";
    scrollWindow.style.transform = "scale(1,1)";
}

function closeModal() {
    body.style.overflow = "visible";
    body.style.paddingLeft = "20px";

    for (i = 0; i < modals.length; i++) {
        backdrops[i].style.opacity = "0";
        backdrops[i].style.filter = "alpha(opacity=0)";

        modals[i].style.visibility = "hidden";

        scrollWindows[i].style.WebkitTransform = "scale(0,0)";
        scrollWindows[i].style.msTransform = "scale(0,0)";
        scrollWindows[i].style.transform = "scale(0,0)";
    }
}
