import.meta.glob([
    '../assets/dash/img/**',
]);

import '../assets/dash/fonts/tajawal/tajawal.css'
import '../assets/dash/css/nucleo-icons.css';
import '../assets/dash/css/nucleo-svg.css';
import '../assets/dash/css/soft-ui-dashboard.css?v=1.1.1';

import '../assets/dash/js/core/popper.min.js';
import '../assets/dash/js/core/bootstrap.min.js';
import '../assets/dash/js/plugins/perfect-scrollbar.min.js';

import '../assets/dash/js/plugins/datatables.js';
import '../assets/dash/js/plugins/choices.min.js';

import '../assets/dash/js/soft-ui-dashboard.min.js?v=1.1.1';

var win = navigator.platform.indexOf('Win') > -1;

if (win && document.querySelector('#sidenav-scrollbar')) {

    var options = {
        damping: '0.5'
    }

    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common[ 'X-Requested-With' ] = 'XMLHttpRequest';


// adding on inputs attributes for calling the focused and defocused functions
if (document.querySelectorAll('.input-group').length != 0) {
    var allInputs = document.querySelectorAll('input.form-control');
    allInputs.forEach(el => setAttributes(el, {
        "onfocus": "focused(this)",
        "onfocusout": "defocused(this)"
    }));
}

// helper for adding on all elements multiple attributes
function setAttributes(el, options) {
    Object.keys(options).forEach(function (attr) {
        el.setAttribute(attr, options[ attr ]);
    })
}

window.focused = (el) => {
    if (el.parentElement.classList.contains('input-group')) {
        el.parentElement.classList.add('focused');
    }
}

// when input is focused remove focused class for style
window.defocused = (el) => {
    if (el.parentElement.classList.contains('input-group')) {
        el.parentElement.classList.remove('focused');
    }
}
