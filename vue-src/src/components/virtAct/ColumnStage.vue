<template>
    <div>
        <div>
            <h1 class='main-title'>{{}}</h1>
        </div>
        <div v-if='!this.showContent' class='stage-wrapper'>
            <div class='stage-wrapper-single' v-for="s in stages" :key="s.stage" v-on:click='() => {this.updateStage(s.stage); this.sContent(s.name)}'>
                <div class="stage-wrapper-single-circle" v-bind:class="{'action': s.stage == this.stage, 'acted': s.ready}">
                    {{1 + s.stage}}
                </div>
                <p>{{s.name}}</p>
            </div>            
        </div>
    </div>
</template>

<script>
export default {
    props: {
        stages: Array,
        stage: Number,
        showContent: Boolean,
    },
    mounted() {
        console.log(this.stages)
    },
    methods: {
        updateStage(i) {
            this.$emit('updateParentState', i)
        },
        sContent(name) {
            this.$store.commit('TITLE', name);
            this.$emit('updateShowContent', true);
        }
    },
}
</script>

<style lang="scss" scoped>

.action {
    color: $color-menu !important;
    border-color: $color-menu !important;
}
.acted {
    color: #FFF !important;
    background-color: $color-menu !important;
    border-color: $color-menu !important;
}
.stage-wrapper{
    background-color: #fff;
    font-size: 1.8rem;
    font-family: 'HelveticaNeue roman';
    box-shadow: 1px 1px 4px 2px rgba(204, 204, 204, 0.3);
    &-single {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        padding: 1rem;
        font-size: 20px;
        border-bottom: 2px solid $color-lightgrey;
        &-circle {
            min-width: 34px;
            border: solid $color-acent 0.113rem;
            color: $color-acent;
            border-radius: 50%;
            text-align: center;
            margin-right: 1rem;
        }
        p {
            margin-bottom: 0;
        }
    }
}
</style>