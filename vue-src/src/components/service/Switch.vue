<template>
    <div class="row container-fluid mt-1 g-3 p-0 align-items-center input">
        <div class="col-sm-3 p-0" :class="{'mt-0': this.first}">
            <label :for="id" class="col-form-label input-label">{{this.label}}<span class='require' v-if="this.require"> *</span></label>
        </div>
        <div class="col-sm-9 p-0 input-wrapper" :class="{'mt-0': this.first}">
            <SwitchSimple :id="id" :dataValue='this.dataValue' :type="this.type" @updateParentState="this.setValue"/>
            <Popper v-if="this.hint" class="bs-tooltip" :content='this.hint'/>
        </div>
    </div>
</template>

<script>
import SwitchSimple from '@/components/service/SwitchSimple';
import Popper from '@/components/service/Popper';
export default {
    components: {
        Popper,
        SwitchSimple
    },
    data() {
        return {
            value: this.dataValue ? true : false,
        }
    },
    props: {
        id: [String, Boolean],
        label: [String],
        hint: [String],
        first: {
            type: Boolean,
            default: false,
        },
        type: {
            default: 'form-switch-xl',
            type: [String]
        }, 
        require: [Boolean],
        dataValue: [String, Boolean],
    },
    methods: {
        setValue(arg) {
            this.$emit('updateParentState', {
                id: arg.id,
                value: arg.value
            })
        }
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