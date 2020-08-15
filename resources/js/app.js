import flatpickr from "flatpickr";
import Swal from 'sweetalert2'
require('./bootstrap')

window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.toaster = function (type = 'success', message = '') {
    Toast.fire({
        icon: type,
        title: message
    })
}

// Flatpicker
window.flatpickr = flatpickr

flatpickr('.datetime', {
    altInput: true,
    altFormat: "Y-m-d H:i",
    dateFormat: "Y-m-d H:i",
    enableTime: true,
});