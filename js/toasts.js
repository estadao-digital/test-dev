
const infoToast     = document.querySelector('#infoToast');
const successToast  = document.querySelector('#successToast');
const warningToast  = document.querySelector('#warningToast');
const errorToast    = document.querySelector('#errorToast');


const boostrapInfoToast       = new bootstrap.Toast(infoToast);
const boostrapSuccessToast    = new bootstrap.Toast(successToast);
const boostrapWarningToast    = new bootstrap.Toast(warningToast);
const boostrapErrorToast      = new bootstrap.Toast(errorToast);


export const Toasts = {

    info: (title, msg) => {
        infoToast.querySelector('.me-auto').innerHTML = title;
        infoToast.querySelector('.toast-body').innerHTML = msg;
        boostrapInfoToast.show()
    },
    success: (title, msg) => {
        successToast.querySelector('.me-auto').innerHTML = title;
        successToast.querySelector('.toast-body').innerHTML = msg;
        boostrapSuccessToast.show()
    },
    warning: (title, msg) => {
        warningToast.querySelector('.me-auto').innerHTML = title;
        warningToast.querySelector('.toast-body').innerHTML = msg;
        boostrapWarningToast.show()
    },
    error: (title, msg) => {
        errorToast.querySelector('.me-auto').innerHTML = title;
        errorToast.querySelector('.toast-body').innerHTML = msg;
        boostrapErrorToast.show()
    },
}