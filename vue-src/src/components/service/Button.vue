<template>
    <button v-if="this.disabled == true"  :style='this.style' v-bind:class="this.type" disabled class='btn disabled'>
        <i v-if='this.icon_i' class='item-i mr-1' :class='this.icon_i'></i>
        {{this.name}}
    </button>
    <button v-else class='btn' :style='this.style' v-bind:class="this.type">
        <i v-if="this.icon_i.length > 1" class='item-i mr-1' :class='this.icon_i'></i>
        {{this.name}}
    </button>
</template>

<script>
export default {
    props: {
        name: [String],
        type: {
            type: String,
            default: 'btn-primary'
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        icon_i: {
            type: String,
            default: '',
        },
        style: {
            type: String,
            default: '',
        }
    },
}
</script>

<style lang="scss" scoped>
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
</style>