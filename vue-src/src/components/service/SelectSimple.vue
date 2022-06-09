<template>
    <div ref='s_cont' :id="id + '_s'" :class="{'disable': this.disable}" class='input-container form-control' tabindex='-1' v-on:click="this.showOpt()">
        <div class="input-container-select" :id="id">
            <span class="input-container-select-value" :class='{"grey": this.name.g}'>{{name.n}}</span>
            <div class="c-arrow"><i :class="{'bi bi-chevron-down': !showOptions, 'bi bi-chevron-up': showOptions}"></i></div>
        </div>
        <transition @enter="enter" @leave="leave">
            <ul ref='o_cont' class="input-container-select-options" v-if="showOptions && !disable">
                <li class="input-container-select-options-li" v-for="keyword in this.keywords" :key="keyword.code" :class="{'acted': this.value == keyword.code}" v-on:click="() => {this.selectOption(keyword.code)}">
                    <label> {{keyword.value}}</label>
                </li>
            </ul>
        </transition>
    </div>
</template>

<script>
import { gsap } from "gsap";

export default {
    data() {
        return {
            value: this.dataValue ? this.dataValue : '',
            showOptions: false,
            name: this.dataValue ? this.getOption(this.dataValue) : '',
        }
    },
    props: {
        id: [String, Boolean],
        keywords: [Array],
        dataValue: [String, Boolean],
        disable: {
            default: false,
            type: [Boolean]
        }
    },
    beforeUnmount() {
        document.querySelector('body').removeEventListener('click', this.clickClose);
    },
    methods: {
        setValue() {
            this.$emit('updateParentState', {
                id: this.id,
                value: this.value
            })
        },
        sortArr() {
            let arr = this.keywords;
            arr.sort((r1, r2) => {
                if (r1.code != this.value && r2.code != this.value ) {
                    return 0;
                }
                if (r1.code == this.value && r2.code != this.value) {

                    return -1;
                }
                if (r1.code != this.value && r2.code == this.value) {
                    return 1;
                }
            });
            console.log(arr);
        },
        showOpt() {
            if (this.disable) {
                this.showOptions = false;
                document.querySelector('body').removeEventListener('click', this.clickClose);
                return;
            }
            // this.sortArr();
            this.showOptions = !this.showOptions;
            this.showOptions ? this.$refs.s_cont.focus() : this.$refs.s_cont.blur();
            document.querySelector('body').addEventListener('click', this.clickClose);
        },
        clickClose(e) {
            if (!this.$el.contains(e.target)) {
                this.showOptions = false;
                document.querySelector('body').removeEventListener('click', this.clickClose);
            }
        },
        enter(el) {
            gsap.fromTo(el, {opacity: 0.6, height: '50%', duration: 0.2}, {opacity: 1, height: 'auto', duration: 0.2});
        },
        leave(el, done) {
            gsap.fromTo(el, {opacity: 1}, {opacity: 0.6, height: 0, duration: 0.1, onComplete: done});
        },
        getOption(code) {
            let val = {};
            this.keywords.forEach(e => {
                if (e.code == code) {
                    if (e.place) {
                        val.g = true;
                    } else {
                        val.g = false;
                    }
                    val.n = e.value;
                }
            });
            return val;
        },
        selectOption(value) {
            this.name = this.getOption(value);
            this.value = value
            this.setValue();
        },
    },
}
</script>

<style lang="scss" scoped>

.input-container:focus:not(.disable) {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
.disable {
    background-color: $color-lightgrey;
    cursor: default !important;
}
.acted {
    background-color: $color-light;
    font-family: HelveticaNeue bold;
}
.input-container {
        padding: 0;
        position: relative;
        cursor: pointer;
        &-select {
            width: 100%;
            z-index: 2000;
            outline:none;
            border: none;
            padding: 0.375rem 0.75rem;
            background: transparent;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-family: 'HelveticaNeue roman';
            .c-arrow, .c-arrow {
                height: 24px;
            }
            &-value {
                height: min-content;
                white-space: nowrap;
                overflow: hidden;
            }
            &-options {
                overflow: hidden;
                padding: 0;
                border-bottom: 1px solid #ced4da;
                border-left: 1px solid #ced4da;
                border-right: 1px solid #ced4da;
                top: 2.17rem;
                left: -0.06rem;
                right: -0.06rem;
                background: #fff;
                position: absolute;
                overflow: auto;
                max-height: 200px;
                z-index: 1000;
                margin: 0;
                list-style-type: none;
                font-family: 'HelveticaNeue roman';
                border-radius: 0 0 0.25rem 0.25rem;
                &-li {
                    padding: 0.375rem 0.75rem;
                    label {
                        font-weight: regular;
                        cursor: pointer;
                    }
                    border-top: 1px solid $color-light;
                }
                &-li:hover {
                    background-color: $color-lightgrey;
                }
            }
        }
}
</style>