<template>
    <div class="row container-fluid mt-1 p-0 g-3 align-items-center input">
        <div class="col-sm-3 p-0" :class="{'mt-0': this.first}">
            <label :for="id" class="col-form-label input-label">{{this.label}}<span class='require' v-if="this.require"> *</span></label>
        </div>
        <div class="col-sm-9 p-0 input-wrapper" :class="{'mt-0': this.first}">
            <SelectSimple :dataValue.sync='this.dataValue' :id='this.id' :keywords.sync='this.keywords' @updateParentState="this.setValue"/>
            <Popper v-if="this.hint" class="bs-tooltip" :content='this.hint'/>
        </div>
    </div>
</template>

<script>
import Popper from '@/components/service/Popper';
import SelectSimple from '@/components/service/SelectSimple';

export default {
    components: {
        Popper,
        SelectSimple
    },
    props: {
        id: [String, Boolean],
        keywords: [Array],
        dataValue: [String, Boolean],
        require: [Boolean],
        hint: [String, Boolean],
        label: [String],
        first: {
            type: Boolean,
            default: false,
        },
        disable: {
            default: false,
            type: [Boolean]
        }
    },
    methods: {
        setValue(arg) {
            this.$emit('updateParentState', {
                id: arg.id,
                value: arg.value
            })
        },
    }
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
.require {
    color: red;
}


</style>