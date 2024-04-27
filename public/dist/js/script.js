$(document).ajaxError((event, jqxhr, settings, thrownError) => {
    switch (jqxhr.status) {
        case 401:
            fireToast('error', jqxhr.statusText, jqxhr.responseJSON.message)
            break;

        default:
            fireToast('error', jqxhr.statusText, jqxhr.responseJSON.message)
            break;
    }
})

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function fireToast(icon, title = '', text = '') {
    Toast.fire({
        icon: icon,
        title: title,
        text: text,
    })
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2)
    return parts.pop().split(';').shift();
}