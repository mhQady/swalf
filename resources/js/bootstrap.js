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
