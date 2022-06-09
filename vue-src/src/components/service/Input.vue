<template>
    <div class="row container-fluid mt-1 p-0 g-3 align-items-center input">
        <div class="col-sm-3 p-0" :class="{'mt-0': this.first}">
            <label :for="id" class="col-form-label input-label">{{this.label}}<span class='require' v-if="this.require"> *</span></label>
        </div>
        <div class="col-sm-9 input-wrapper p-0" :class="{'mt-0': this.first}">
            <InputSimple :id="id" :type=type :disabled='this.disabled' :dataValue='this.dataValue' @updateParentState="this.setValue"/>
            <Popper v-if="this.hint" class="bs-tooltip" :content='this.hint'/>
        </div>
    </div>
</template>

<script>
import InputSimple from '@/components/service/InputSimple';
import Popper from '@/components/service/Popper';

export default {
    components: {
        Popper,
        InputSimple
    },
    data() {
        return {
            value: this.dataValue ? this.dataValue : '',
            sizeW: this.$store.state.resize.w,
        }
    },
    props: {
        id: [String, Boolean],
        first: {
            type: Boolean,
            default: false,
        },
        label: [String],
        type: [String],
        hint: [String, Boolean],
        dataValue: [String, Boolean], 
        require: [Boolean],
        disabled: [String, Boolean]
    },
    methods: {
        setValue(arg) {
            this.$emit('updateParentState', {
                id: arg.id,
                value: arg.value
            })
        }
    },
    mounted() {
    },

}
</script>

<style lang="scss" scoped>
.input {
    font-family: 'HelveticaNeue roman';
    &-wrapper {
        position: relative;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
    }
}
.mt-1 {
    margin: 0 !important;
}
.require {
    color: red;
}

</style>