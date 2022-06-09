<template>
    <div class="dropdown">
        <a class="btn btn-outline-warning dropdown-toggle" :style='this.style' v-on:click="this.open" href="#" role="button">
            {{this.label}}
        </a>

        <ul v-if="this.active" class="dropdown-menu" :class="this.position">
            <li v-for="(row, index) in this.menu" :key="index" >
                <a class="dropdown-item" href="#" v-on:click="(e) => {row.handler(); this.close(e);}">{{row.name}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
import { gsap } from "gsap";

export default {
    props: {
        menu: [Array],
        label: {
            default: '',
            type: [String, Boolean]
        },
        style: {
            default: '',
            type: [String, Boolean]
        },
        position: {
            default: '',
            type: [String, Boolean]
        }
    },
    data() {
        return {
            active: false,
        }
    },
    methods: {
        open() {
            this.active = true;
            document.querySelector('body').addEventListener('mouseover', this.close);
        },
        close(e) {
            if (!this.$el.contains(e.target) || e.type == 'click') {
                this.active = false;
                document.querySelector('body').removeEventListener('mouseover', this.close);
            }
        },
        enter(el) {
            gsap.fromTo(el, {opacity: 0.1, height: '95%'}, {opacity: 1, height: 'auto', duration: 0.1});
        },
        leave(el, done) {
            gsap.fromTo(el, {opacity: 1}, {opacity: 0.1, duration: 0.2, onComplete: done});
        },
    },
}
</script>

<style lang="scss" scoped>
.dropdown-menu {
    display: block;
}
.dropdown a{
    min-height: 38px;
    display: block;
}
.btn {
    box-shadow: none;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
.btn .item-i {
    height: 1.3em;
    width: 1.3em;
}
.btn-warning {
    color: white;
    background-color: $color-warning;
    border-color: $color-warning;
}
.btn-warning:hover:not(.disabled) {
    color: white;
    background-color: $color-warning;

    filter: saturate(200%);
}
.disabled {
    filter: saturate(10%);
}
.btn-outline-warning {
    color: $color-warning;
    border-color: $color-warning;
    border-color: $color-warning;
}
.btn-outline-warning:hover:not(.disabled) {
    color: white;
    background-color: $color-warning;
    border-color: $color-warning;
}
.lg-left {
    @media (min-width: 991px) {
        left: 1%;
    }
}
.right {
    right: 1%;
}
</style>