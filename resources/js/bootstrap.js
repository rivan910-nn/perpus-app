/**
 * File bootstrap untuk konfigurasi JavaScript Laravel.
 * File ini dapat digunakan untuk konfigurasi Axios dan CSRF.
 */

import axios from "axios";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
