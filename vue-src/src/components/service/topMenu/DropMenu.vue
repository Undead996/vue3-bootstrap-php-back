<template>
    <li class="dropdown-t">
        <span ref="ddt" class="navbarDropdown" :class="{'link-active': this.active, bg: this.type == 'burger'}" v-on:mouseover="this.open">
            <span v-if="this.type == 'left'"><i class='item-i' :class="{'arrow-down-right-active': this.active, 'arrow-down-right': !this.active}"></i> Пополнить </span>
            <span v-else-if="this.type == 'right'">Вывести<i class='item-i' :class="{'arrow-up-right-active': this.active, 'arrow-up-right': !this.active}"></i></span>
            <span v-else-if="this.type == 'user'">
                <img v-if="this.$store.state.userData.avatar" class='user_img' :src="this.$store.state.userData.avatar" />
                <img v-else class='user_img' src="@/assets/user.svg"/>
                
                {{this.$store.getters.get_user_name}}
                </span>
            <span v-else-if="this.type == 'burger'"><i class='item-i' :class="{'burger-active': this.active, 'burger': !this.active}"></i></span>
            <span v-else> Dropdown </span>
        </span>
        <transition @enter="enter" @leave="leave">
        <div ref="ddm" class="container content dropdown-m p-5" v-show="this.active" :class="{left: this.type == 'left', right: this.type == 'right' || this.type == 'user' || this.type == 'burger'}">
            <div v-if="this.type == 'left'" class="row align-items-start">
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i crypt'></i><h4>Криптовалютой</h4></a>
                    <a href="#" class="simple-a"><i class='item-i btc'></i>BTC</a>
                    <a href="#" class="simple-a"><i class='item-i eth'></i>ETH</a>
                    <a href="#" class="simple-a"><i class='item-i usdt'></i>USDT</a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i icard'></i><h4>Картой</h4></a>
                    <a href="#" class="mt-3">
                        <i class='item-i mb-4 p2p'></i>
                        <span>
                            <h4>PTP</h4>
                            <p class='m-0'>(обмен на местном рынке)</p>
                        </span>
                    </a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Мои сделки</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Новое объявление</a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i bookmark'></i><h4>Шаблоны</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 1</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 2</a>
                </div>
            </div>
            <div v-if="this.type == 'right'" class="row align-items-start">
                <div class='col d-flex flex-column'>
                    <a href="#">
                        <i class='item-i mb-4 p2p'></i>
                        <span>
                            <h4>PTP</h4>
                            <p class='m-0'>(обмен на местном рынке)</p>
                        </span>
                    </a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Мои сделки</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Новое объявление</a>
                    <a href="#" class="mt-3"><i class='item-i mb-4 transfer'></i><h4>Перевод другим клиентам биржи</h4></a>
                </div>
                <div class='col d-flex flex-column'>
                    <router-link to="/pay" v-on:click='this.close'><i class='item-i pay'></i><h4>Оплата услуг</h4></router-link>
                    <a href="#" class="simple-a"><i class='item-i'></i>Сотовая связь</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Интернет</a>
                    <a href="#" class="mt-3"><i class='item-i icard'></i><h4>На карту</h4></a>
                    <a href="#" class="mt-3"><i class='item-i bank'></i><h4>На банковский счет</h4></a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i bookmark'></i><h4>Шаблоны</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 1</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 2</a>
                </div>
            </div>
            <div v-if="this.type == 'user'" class="row align-items-start">
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i profile'></i><h4>Идентификация</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Регистрационные данные</a>
                    <router-link to="/keyts" class="mt-3" v-on:click='this.close'><i class='item-i icard'></i><h4>Счета</h4></router-link>
                    <a href="#" class="mt-3"><i class='item-i mailbox'></i><h4>Другие пользователи</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Внутренния почта</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Проверка корреспондента</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Список контактов</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Поддержка</a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#" class='not'><i class='item-i lock'></i><h4>Безопасность</h4></a>
                    <router-link to="/safety/pass" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Пароль</router-link>
                    <router-link to="/safety/pay_pass" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Платежный пароль</router-link>
                    <router-link to="/safety/antiphishing" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Антифишинг</router-link>
                    <router-link to="/safety/ip" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Доступ по IP</router-link>
                    <router-link to="/safety/magic" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Волшебное слово</router-link>
                    <router-link to="/safety/onekey" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Одноразовые ключи</router-link>
                    <router-link to="/safety/secret_question" class="simple-a" v-on:click='this.close'><i class='item-i'></i>Секретный вопрос</router-link>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i notification'></i><h4>Уведомления</h4></a>
                    <a href="#" class="mt-3"><i class='item-i headphones'></i><h4>Поддержка</h4></a>
                    <a href="#" class="mt-3"><i class='item-i bookmark'></i><h4>Шаблоны</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 1</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Шаблон 2</a>
                    <a href="#" class="mt-3" v-on:click="this.logout"><i class='item-i logout'></i><h4>Выход из аккаунта</h4></a>
                </div>
            </div>
            <div v-if="this.type == 'burger'" class="row align-items-start">
                <div class='col d-flex flex-column'>
                    <a href="#" class='not'><i class='item-i crypt'></i><h4>Виртуальные активы</h4></a>
                    <router-link to="/va/new" v-on:click='this.close' class="simple-a"><i class='item-i'></i>Выпуск новой валюты</router-link>
                    <router-link to="/va/list" v-on:click='this.close' class="simple-a"><i class='item-i'></i>Мои валюты</router-link>
                    <a href="#" class="mt-3"><i class='item-i invest'></i><h4>Инвестиции</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Инвестирование</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Привлечение инвестиций</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Вклады</a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i pay'></i><h4>Сборы</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Собирю</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Сдаю</a>
                    <a href="#" class="mt-3"><i class='item-i p2p'></i><h4>Внутренние переводы</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Другим пользователям</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>По своим счетам</a>
                </div>
                <div class='col d-flex flex-column'>
                    <a href="#"><i class='item-i docs'></i><h4>Счета к оплате</h4></a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Входящие</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Выставленные мной</a>
                    <a href="#" class="simple-a"><i class='item-i'></i>Выставить счет</a>
                    <router-link to="/history" class='mt-3' v-on:click='this.close'><i class='item-i bank'></i><h4>История операций</h4></router-link>
                </div>
            </div>
        </div>
        </transition>
    </li>
</template>

<script>
import { gsap } from "gsap";

export default {
    props: {
        type: [String],
    },
    data() {
        return {
            active: false,
        }
    },
    methods: {
        open() {
            this.active = true;
            this.$store.commit('DARK_WRAPPER', true);
            document.querySelector('body').addEventListener('mouseover', this.close);
        },
        close(e) {
            if (!this.$el.contains(e.target) || e.type == 'click') {
                this.active = false;
                this.$store.commit('DARK_WRAPPER', false);
                document.querySelector('body').removeEventListener('mouseover', this.close);
            }
        },
        enter(el) {
            gsap.fromTo(el, {opacity: 0.1, height: '95%'}, {opacity: 1, height: 'auto', duration: 0.1});
        },
        leave(el, done) {
            gsap.fromTo(el, {opacity: 1}, {opacity: 0.1, duration: 0.2, onComplete: done});
        },
        logout() {
            this.$store.dispatch('logout', this.$router);
        },
    },
}
</script>

<style lang="scss" scoped>

.dropdown-t {
    height: 100%;
    .navbarDropdown {
        span {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            cursor: pointer;
        }
        .user_img {
            width: 35px;
            height: 35px;
            margin-right: 0.5rem;
            border-radius: 50%;
        }
    }
    .dropdown-m {
        position: absolute;
        max-width: max-content;
        max-width: 80%;
        z-index: 3000;
        box-shadow: 2px 2px 4px 2px rgba(1, 52, 23, 0.1);
        border-radius: 0px 0px 6px 6px;
        .item-i {
            margin-right: 0.5rem;
        }
        .simple-a {
            font-size: 1rem;
        }
        a {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            cursor: pointer;
            font-family: 'HelveticaNeue roman';
            transition: all 0.2s;
            // color: red !important;
            p {
                font-family: 'HelveticaNeue light';
            }
            h4 {
                margin: 0;
                font-size: 1.35rem;
            }
        }
        a:hover {
            color: $color-acent;
        }
        .not {
            cursor:default;
        }
        .not:hover {
            color: #000 !important;
        }
    }
    .navbarDropdown {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-bottom: 4px solid transparent;
        box-sizing: padding-box;
        margin: 0 1.4rem;
        color: #FFF;
    }
}
.left {
    left: 0;
}
.right {
    right: 0;
}
.link-active {
    border-bottom: 4px solid $color-menu-active !important;
    color: $color-menu-active !important;
}
.bg {
    margin-right: 0 !important;
}

</style>