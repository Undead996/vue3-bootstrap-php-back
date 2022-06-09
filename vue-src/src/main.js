import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "@/includes/_icons.scss";
import { createApp } from 'vue'
import App from './App.vue'
import router from '@/router'
import store from '@/store'
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueCookies from 'vue3-cookies'
import lib from '@/includes/lib.js';

axios.interceptors.response.use(function (res) {
    lib.res(res, store, router);
    return res;
  }, function (error) {
    lib.err(error, store, router);
    // return Promise.reject(error);
  });

axios.interceptors.request.use(function (req) {
    lib.req(req, store, router);
    return req;
  }, function (error) {
    return Promise.reject(error);
  });

createApp(App).use(store).use(router).use(VueAxios, axios).use(VueCookies).mount('#app');

import "bootstrap/dist/js/bootstrap.js";

