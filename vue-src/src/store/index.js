import { createStore } from 'vuex'
import axios from 'axios';

export default createStore({
  state: {
    isLogged: false,
    resize: {
      w: false,
      h: false,
    },
    isMobile: false,
    loader: false,
    error: false,
    fingerprint: false,
    pay_pass: false,
    modal: {
      action: false,
      type: false,
      content: false,
    },
    darkWrapper: false,
    title: '',
    userData: false,
  },
  mutations: {
    IS_LOGGED: (state, n) => {
      state.isLogged = n;
    },
    TITLE: (state, n) => {
      state.title = n;
    },
    RESIZE: (state, n) => {
      state.resize = n;
    },
    IS_MOBILE: (state, n) => {
      state.isMobile = n;
    },
    FINGERPRINT: (state, n) => {
      state.fingerprint = n;
    },
    PAY_PASS: (state, n) => {
      state.pay_pass = n;
    },
    MODAL: (state, n) => {
      state.modal = n;
    },
    MODAL_ACTION: (state, n) => {
      state.modal.action = n;
    },
    MODAL_TYPE: (state, n) => {
      state.modal.type = n;
    },
    MODAL_CONTENT: (state, n) => {
      state.modal.content = n;
    },
    LOADER: (state, n) => {
      state.loader = n;
    },
    DARK_WRAPPER: (state, n) => {
      state.darkWrapper = n;
    },
    USER_DATA: (state, n) => {
      if (n.user_info) {
        if (n.user_info.avatar.value) {
          n.avatar = "data:;base64," + n.user_info.avatar.value.split(":").slice(0, -1).join(":");  
        }
      }
      state.userData = n;
    },
    ERROR: (state, n) => {
      state.error = n;
    },
  },
  actions: {
    logout(context, router) {
      axios.post('logout').then(res => {console.log('logout');
        // context.commit('USER_DATA', false);
      });
    },
    modalAnswer(context, p) {
      context.commit('MODAL_ACTION', true);
      context.commit('MODAL_TYPE', 'answer');
      context.commit('MODAL_CONTENT', {result: p.code,
                                       result_text: p.text});
    },
    isLogged(content) {
      axios.post('isLogged').then(res => {
        content.commit('USER_DATA', res.data.body)
      })
    },
  },
  modules: {
  },
  getters: {
    get_isLogged (state) {
      return state.isLogged;
    },
    get_user_name (state) {
      let str = state.userData.user_info.surname.value + ' ' + state.userData.user_info.firstname.value.charAt(0) + '. ';
      if (state.userData.user_info.patronymic.value) {
        str = str + state.userData.user_info.patronymic.value.charAt(0) + '.';
      }
      return str;
    },
  }
})
