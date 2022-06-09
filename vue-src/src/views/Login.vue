<template>
    <div class='container-fluid p-0 d-flex auth-bg justify-content-center align-items-center min-vh-100'>
        <div v-if='this.$store.state.userData' class='col-xl-5 col-sm-7 auth-container'>
            <div class='mx-auto bp-1 auth-logo'>
                <img src='@/assets/logo.svg'>
            </div>
            <div class='content d-flex flex-column justify-content-around align-items-center'>
                    <h3 class='mt-4 neue-bold'>Авторизация</h3>
                    <div class='container-fluid p-0'>
                        <p class='mt-2 mb-1 neue-roman'>Логин: </p>
                        <InputSimple id="cabinet_login" autofocus @keyup="this.next" @updateParentState="this.updateState"/>
                    </div>
                    <div class='container-fluid p-0'>
                        <p class='mt-4 mb-1 neue-roman'>Пароль: </p>
                        <InputSimple ref="pass" type='password' id="pass" @keyup="this.submit" @updateParentState="this.updateState"/>
                        <p class='mt-1 grey'>Забыли пароль?</p>
                    </div>
                    <div class='mx-auto mt-4'>
                        <Button name='Войти'  :style='"width: 120px"' type='btn-warning' v-on:click="this.login"/>
                    </div>
                    <div class='text-center mt-4 neue-roman'>
                        <p class='alt-mb'>Впервые здесь? <a href='#' class='href'>Создайте аккаунт</a></p>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputSimple from '@/components/service/InputSimple';
import Button from '@/components/service/Button';

export default {
    components: {
        InputSimple,
        Button
    },
    data() {
        return {
            data: {
                cabinet_login: '',
                pass: '',
            },
        }
    },
    mounted() {
        if (this.$store.state.isLogged) {
            this.$store.dispatch('logout', this.$router);
        }
        // setTimeout(() => {
        //     this.$refs.login.focusInput();
        // }, 1000);
    },
    methods: {
        login() {
            this.axios.post('login', {cabinet_login: this.data.cabinet_login, password: this.data.pass}).then(res => this.$store.commit('USER_DATA', res.data.body));
        },
        updateState(state) {
            this.data[state.id] = state.value;
        },
        next(e) {
            if (e.keyCode === 13) {
                this.$refs.pass.focusInput();
            }
        },
        submit(e) {
            if (e.keyCode === 13) {
                this.login();
            }
        }
    }
}
</script>

<style lang="scss">
.auth-logo {
    max-width: min-content;
}
.auth-container {
    max-width: 465px;
    .content {
        padding: 1rem 1.3rem;
    }
    .alt-mb {
        margin-bottom: 0.6rem;
    }
}
</style>