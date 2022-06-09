<template>
    <Datepicker v-if='this.type == "date"'
     v-model="date" locale='ru' 
     :format="this.format"
     :placeholder="this.placeholder" 
     autoApply autocomplete="off"
     :maxDate="this.max"
     :minDate="this.min" 
     :enableTimePicker="false"
     :clearable="this.clearable"
      @update:modelValue="this.setValue">
    </Datepicker>
    <Datepicker v-else-if='this.type == "time"'
     v-model="date" locale='ru' autoApply 
     :format="this.format"
     :maxDate="this.max"
     :minDate='this.min' 
     :clearable="this.clearable"
      @update:modelValue="this.setValue" 
      timePicker>
    </Datepicker>
</template>
<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import {ref} from 'vue';

export default {
    components: {
        Datepicker,
    },
    props: {
        id: [String, Boolean],
        dataValue: [String, Boolean],
        type: {
            default: 'date',
            type: [String, Boolean]
        },
        min: {
            default: new Date('1900'),
            type: [Date, Boolean]
        },
        max: {
            default: new Date('2100'),
            type: [Date, Boolean]
        },
        placeholder: {
            default: '',
            type: [String, Boolean]
        },
        clearable: {
            default: false,
            type: [Boolean]
        },
    },
    watch: {
        dataValue(newd, oldd) {
            let d = this.date
            if (newd != false) {
                this.date = new Date(newd)
            }
        }
    },      
    setup(props) {
        let date = ref(new Date());
        let format = 'dd.MM.yyyy';
        // if (props.type == 'date') {
            // date = props.dataValue ? ref(props.dataValue) : ref(new Date);

            // format = (date) => {
            //     let day = date.getDate();
            //     let month = date.getMonth() + 1;
            //     let year = date.getFullYear();

            //     return `${day}.${month}.${year}`;
            // }
        
        if (props.type == 'time') {
            date = ref({ 
                hours: new Date().getHours(),
                minutes: new Date().getMinutes()
            });
            format = 'HH:mm';
        }

        return {
            format,
            date
        }
    },
    mounted() {
        this.setValue();
    },
    methods: {
        setValue() {
            let t = ''
            if ((this.type == 'time')) {
                t = new Date();
                t.setHours(this.date.hours, this.date.minutes);
            } else {
                t = this.date ? this.date.toISOString().split('T')[0] : false;
            }
            this.$emit('updateParentState', {
                id: this.id,
                value: t
            })
        }
    },

}
</script>

<style lang="scss">
.inval {
    input  {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
}
</style>