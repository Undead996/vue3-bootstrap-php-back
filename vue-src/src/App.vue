<template>
  <div class='wrapper'>
    <Modal v-if="this.$store.state.modal.action"/>
    <HeadNav v-if="this.$store.state.isLogged && this.$store.state.userData.user_info"/>
    <transition @enter="enter" @leave="leave">
      <div v-if="this.$store.state.darkWrapper" class='dark-wrapper'></div>
    </transition>
    <Loading :active.sync="this.$store.state.loader" 
        :can-cancel="false" />
    <div class='page-wrapper'>
      <router-view v-if="this.$store.state.isLogged && this.$store.state.userData"/>
      
      <Login v-else/>
    </div>
  </div>
</template>

<script>
import UseClientJs from '@/includes/fingerprint.js';
import HeadNav from '@/components/service/HeadNav'
import Loading from 'vue-loading-overlay';
import Modal from '@/components/service/Modal';
import Login from '@/views/Login';
import 'vue-loading-overlay/dist/vue-loading.css';
import { gsap } from "gsap";

export default {
  components : {
    HeadNav,
    Loading,
    Modal,
    Login
  },
  created() {
    let client = new UseClientJs();
	  let fingerPrint = client.getRetailFingerptint();
    this.$store.commit('FINGERPRINT', fingerPrint);
    this.$store.commit('RESIZE', {
        w: document.documentElement.clientWidth,
        h: document.documentElement.clientHeight
    })
    this.getSize();
    window.addEventListener('resize', this.updateSize);
    this.isLogged();
  },
  methods: {
    isLogged() {
      this.$store.dispatch('isLogged');
    },
    updateSize() {
      this.$store.commit('RESIZE', {
        w: document.documentElement.clientWidth,
        h: document.documentElement.clientHeight
      })
      this.getSize();
    },
    getSize() {
      if (document.documentElement.clientWidth < 576) {
        this.$store.commit('IS_MOBILE', true);
      } else {
        this.$store.commit('IS_MOBILE', false);
      }
    },
    enter(el) {
      gsap.fromTo(el, {opacity: 0}, {opacity: 0.1, duration: 0.2});
    },
    leave(el, done) {
      gsap.fromTo(el, {opacity: 0.1}, {opacity: 0, duration: 0.2, onComplete: done});
    },

  },
}
</script>

<style lang="scss">
@import "@/includes/_fonts.scss";
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

html {
  font-size: 16px;
  font-family: HelveticaNeue;
  // @media (max-width: 1500px) {
  //   font-size: 14px;
  // }
  // @media (max-width: 1350px) {
  //   font-size: 12px;
  // }
  // @media (max-width: 1120px) {
  //   font-size: 11px;
  // }
  // @media (max-width: 1000px) {
  //   font-size: 10px;
  // }
}
.grey {
  color: $color-grey;
}
.color-menu {
  color: $color-menu;
}
.href {
  color: $color-href !important;
}
.pl-0 {
  padding-left: 0 !important;
}
.bp-1 {
  padding-bottom: 2rem !important;
}
.pr-0 {
  padding-right: 0 !important;
}
.pl-1 {
  padding-left: 0.7rem !important
}
.pl-2 {
  padding-left: 1.4rem !important
}
.pl-4 {
  padding-left: 3.6rem !important
}
.my-1 {
  margin: 0.45rem 0 !important;
}
.my-2 {
  margin: 1.2rem 0 !important;
}
.mt-0 {
  margin-top: 0 !important;
}
.mt-1 {
    margin: 0 !important;
}
.mt-2 {
    margin-top: 0.7rem !important;
}
.pr-1 {
  padding-right: 0.7rem;
}
.mr-1 {
  margin-right: 0.7rem !important;
}
.ml-2 {
  margin-left: 0.7rem !important;
}

a {
  text-decoration: none !important;
  color: #000;
}

#app {
  color: #2c3e50;
  background-color:$color-background;
  min-height: 100%;
  width: 100%;
}
.neue-bold {
  font-family: 'HelveticaNeue bold' !important;
}
.neue-roman {
  font-family: 'HelveticaNeue roman' !important;
}
.neue {
  font-family: 'HelveticaNeue' !important;
}
h4 {
    font-family: 'HelveticaNeue bold';
}
h5, h3 {
  font-family: 'HelveticaNeue roman';
}

.href {
  cursor: pointer;
}

.auth-bg {
    background-image: url('~@/assets/auth_bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-clip: padding-box;
}
.btn_mb {
  text-align: center !important;
}
.btn_mb button, button.btn_mb {
  width: 90%;
  margin-top: 1rem;
}
.wrapper {
  position: relative;
  min-height: 100vh;
}
.dark-wrapper {
  bottom: 0;
  top: 0;
  width: 100%;
  background-color: #000;
  position: absolute;
  z-index: 2000;
}
.page-wrapper {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
}
.content {
  background-color: #FFFFFF;
  box-shadow: 2px 2px 4px 2px rgba(1, 52, 23, 0.1);
  border-radius: 12px;
  margin-bottom: 2rem;
}
    .buttons-container {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        width: 100%;
        margin-top: 1rem;
        padding-bottom: 1rem;
        button {
            margin: 0 0.5rem;
        }
    }
</style>
