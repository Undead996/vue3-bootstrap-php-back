<template>
    <div class="form-check form-control-lg form-switch" :class="this.type">
        <input class="form-check-input" type="checkbox" role="switch" :id="id" v-model="this.value" v-on:input="this.setValue">
        <label class="form-check-label" :for="id">{{this.label ? this.label : ''}}</label>
    </div>
</template>

<script>

export default {
    data() {
        return {
            value: this.dataValue ? this.dataValue : '',
        }
    },
    props: {
        id: [String, Boolean],
        label: [String, Boolean],
        dataValue: [String, Boolean],
        type: {
            default: 'form-switch-xl',
            type: [String]
        } 
    },
    methods: {
        setValue() {
            this.value = !this.value
            this.$emit('updateParentState', {
                id: this.id,
                value: this.value
            })
        }
    },

}
</script>

<style lang="scss">
.form-switch.form-switch-xl .form-check-input {
  height: 2rem;
  width: calc(2.7rem + 0.75rem);
  border-radius: 5rem;
}
.form-switch .form-check-input:focus, .form-switch .form-check-input {
    border: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='white'/%3e%3c/svg%3e");
}
.form-check.form-switch {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    .form-check-input {
        box-shadow: none;
    }
    .form-check-label {
        padding-left: 1rem;
    }
}
.form-check-input {
    background-color: $color-lightgrey;
    border-color: $color-lightgrey;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: $color-system-green;
    border-color: $color-system-green;
}
</style>