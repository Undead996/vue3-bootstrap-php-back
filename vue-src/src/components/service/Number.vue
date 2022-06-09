<template>
    <div class="row container-fluid mt-1 g-3 p-0 align-items-center input">
        <div class="col-sm-3 p-0">
            <label :for="id" class="col-form-label input-label">{{this.label}}<span class='require' v-if="this.require"> *</span></label>
        </div>
        <div class='col-sm-9 p-0 input-wrapper'>
            <div class="row align-items-center col-sm-9">
                <div class="col-4">
                    <input class='form-control input-container' :id="id" type='text' v-model="this.value" v-on:input="this.validate">
                </div>
                <div class="d-flex justify-content-evenly col-2">
                    <Button name='+' type='btn-outline-warning btn-sm' v-on:click="() => {this.changeValue(1)}"/>
                    <Button name='-' type='btn-outline-warning btn-sm' v-on:click="() => {this.changeValue(-1)}"/>
                </div> 
            </div>
            <Popper class="bs-tooltip" :content='this.hint'/>
        </div>
        <!-- <Popper v-if="this.hint && !this.$store.state.isMobile" class='col-lg-1 col-md-1 col-sm-2' :content='this.hint'/> -->
    </div>
</template>

<script>
import Button from './Button.vue';
import Popper from '@/components/service/Popper';
export default {
  components: { 
    Button,
    Popper
  },
    data() {
        return {
            value: this.dataValue ? this.dataValue : '',
        }
    },
    props: {
        id: [String, Boolean],
        label: [String],
        hint: [String],
        dataValue: [Number, Boolean, String],
        require: [Boolean]
    },
    methods: {
        setValue() {
            this.$emit('updateParentState', {
                id: this.id,
                value: this.value
            })
        },
        changeValue(i) {
            if ((+this.value + i) >= 0 ) {
                this.value = +this.value + i;
            }
            this.setValue();
        },
        validate() {
            this.value = parseInt(this.value.replace(/\D+/g, ''));
            this.setValue();
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
    .btn-sm {
        min-width: 1.8rem;
    }
}
.require {
    color: red;
}

</style>