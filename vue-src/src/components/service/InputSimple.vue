<template>
    <input :id="id" :type=type ref='input' class="form-control input-container" :disabled='this.disabled' v-model="this.value" v-on:input="this.setValue">
</template>

<script>

export default {
    data() {
        return {
            value: this.dataValue ? this.dataValue : '',
            sizeW: this.$store.state.resize.w,
        }
    },
    props: {
        id: [String, Boolean],
        type: [String],
        dataValue: [String, Boolean], 
        disabled: [String, Boolean],
        autofocus: [Boolean],
    },
    mounted() {
        if (this.autofocus) {
            this.$nextTick(() => this.focusInput())
        }
    },
    methods: {
        setValue() {
            this.$emit('updateParentState', {
                id: this.id,
                value: this.value
            })
        },
        focusInput() {
            this.$refs.input.focus();
        }
    },

}
</script>

<style lang="scss">
.invalid-feedback {
    display: block;
}
.invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
input::placeholder {
    color: $color-grey !important;
}
input {
    font-family: "HelveticaNeue roman";
}
</style>