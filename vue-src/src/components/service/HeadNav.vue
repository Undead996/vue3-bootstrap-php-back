<template>
    <div class='header navbar bd-nawbar p-0'>
        <div class='container-xl p-0'>
        <div class='container-fluid flex-md-nowrap top-menu'>
            <div class='logo'>
                <a href='/'>
                    <img src='@/assets/logo.svg'>
                </a>
            </div>
            <div v-if="this.$store.state.resize.w > 860" class='nav'>
                <DropMenu type="left"/>
                <router-link to="/"><h4>Биржа</h4></router-link>
                <DropMenu type="right"/>
            </div>
            <div class='nav'>
                <DropMenu v-if="this.$store.state.resize.w > 478" type="user"/>
                <DropMenu type="burger"/>
            </div>
        </div>
        </div>
        <div v-if='this.$store.state.userData.antiphishing' ref="antiph" class='antiphishing'>
            <div class='container-xxl'>
                <div class='container-fluid position-relative'>
                    <h5 class='antiphishing-text m-2'>{{this.$store.state.userData.antiphishing}}</h5>
                    <i class='item-i cross' v-on:click='() => {this.$refs.antiph.remove()}' ></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DropMenu from '@/components/service/topMenu/DropMenu.vue';

export default {
    name: 'HeadNav',
    components: {
        DropMenu
    },
    methods: {
        logout() {
            this.axios.post('logout').then(res => {console.log('logout')
            this.$store.commit('USER_DATA', false)
            this.$router.push("/login")});
        }
    }
}
</script>

<style lang="scss" scoped>
.header {
    background-color: $color-menu;
    box-shadow: 1px 2px 8px 2px rgba(204, 204, 204, 0.5);
    font-family: 'HelveticaNeue light';
    z-index: 3000;
    flex-direction: column;
    .top-menu {
        height: 75px;
        position: relative;
        display: flex;
        flex-wrap: inherit;
        align-items: center;
        justify-content: space-between;
        .nav {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            height: 100%;
            h4 {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                border-bottom: 4px solid transparent;
                box-sizing: padding-box;
                margin: 0 1.4rem;
                color: #FFF;
            }
            .router-link-active {
                h4 {
                    color: $color-menu-active;
                }
            }
        }
        .service {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            height: 100%;
            img {
                width: 25px;
            }
        }
    }
}
.antiphishing {
    background-color: $color-light-blue;
    font-size: 1rem;
    width: 100%;
    text-align: center;
    &-text {
        font-size: 1.1rem;
    }
    i {
        position: absolute;
        right: 5px;
        top: -5px;
        cursor: pointer;
    }
}
</style>