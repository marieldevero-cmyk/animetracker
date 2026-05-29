import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Swal from 'sweetalert2';
import { initCharts } from './dashboard';

window.Swal = Swal;

window.showSuccessToast = function (message) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#fcfaf2',
        color: '#2d5a27',
        iconColor: '#2d5a27',
        customClass: {
            popup: 'rounded-4 shadow-lg border-0',
        },
    });
};

document.addEventListener('DOMContentLoaded', initCharts);

window.showErrorToast = function (message) {
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fcfaf2',
        color: '#c1663e',
        iconColor: '#c1663e',
        customClass: {
            popup: 'rounded-4 shadow-lg border-0',
        },
    });
};
