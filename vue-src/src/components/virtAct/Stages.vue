<template>
    <div class='stage pt-3' :class="{'w-padding': this.w == true}">
        <div class='stage-wrapper'>
            <div v-for="s in stages" :key="s.stage" class="stage-wrapper-single" v-on:click='() => {this.updateStage(s.stage)}' v-bind:class="{'action': s.stage == this.stage, 'acted': s.ready}">
                <div class="stage-wrapper-single-left">
                    <div class="stage-wrapper-single-circle">
                        {{1 + s.stage}}
                    </div>
                    <p v-if="this.w">{{s.name}}</p>
                </div>
                <span v-if="1 + s.stage < stages.length" class='stage-wrapper-single-line' v-bind:class="{'up': (1 + s.stage) % 2 != 0, 'down': (1 + s.stage) % 2 == 0 }"></span>
            </div>
        </div>
    </div>    
</template>

<script>
export default {
    props: {
        stages: Array,
        stage: Number,
    },
    data() {
        return {
            act: false,
            w: true,
        }
    },
    created() {
        window.addEventListener('resize', this.checkSize);
    },
    computed: {
        stageColor: function (i) {
            return {
                action: i == this.stage,
                acted: i < this.stage
            }
        }
    },
    methods: {
        updateStage(i) {
            this.$emit('updateParentState', i)
        },
        checkSize() {
            this.w = this.$store.state.resize.w > 850 ? true : false;
        }
        
    },
}
</script>

<style lang="scss" scoped>
    .w-padding {
        padding-bottom: 70px;
    }
    .stage {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        height: max-content;
        &-wrapper {
            margin: 0 auto;
            width: 90%;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            .action {
                .stage-wrapper-single-circle{
                    outline: 7px solid $color-outline;
                    outline-offset: -1px;
                    border-color: $color-outline !important;
                }
                div {
                    color: $color-menu !important;
                    border-color: $color-menu;
                }
                .up {
                    background-image: url('~@/assets/av/upc.svg') !important;
                }
                .down {
                    background-image: url('~@/assets/av/downc.svg') !important;
                }
                p {
                    color: $color-menu !important;
                }
            }
            .acted {
                .stage-wrapper-single-circle{
                    color: #FFF !important;
                    background-color: $color-menu;
                }
                div {
                    border-color: $color-menu;
                }
                .up {
                    background-image: url('~@/assets/av/upc.svg') !important;
                }
                .down {
                    background-image: url('~@/assets/av/downc.svg') !important;
                }
                p {
                    color: $color-menu !important;
                }
            }
            &-single:not(:last-child) {
                flex: 1;
            }
            &-single {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                font-family: 'HelveticaNeue light';
                font-size: 18px;
                &-left {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    cursor: pointer;
                    p {
                        // width: 100%;
                        position: absolute;
                        max-width: 120px;
                        top: 70px;
                    }
                }
                &-circle {
                    width: 1.7em;
                    height: 1.7em;
                    border: solid $color-grey 0.113rem;
                    color: $color-grey;
                    border-radius: 50%;
                    font-size: 1.3rem;
                    margin-bottom: 0.5rem;
                    text-align: center;
                }
                &-line {
                    display: block;
                    position: relative;
                    height: 2em;
                    width: 100%;
                    background-position: center;
                    background-repeat: no-repeat;
                    color: $color-grey;
                }
                .up {
                    background-image: url('~@/assets/av/up.svg');
                    top: -0.35rem;
                }
                .down {
                    background-image: url('~@/assets/av/down.svg');
                    top: 0.35rem;
                }
                p {
                    color: $color-grey;
                }
            }
        }
    }
</style>