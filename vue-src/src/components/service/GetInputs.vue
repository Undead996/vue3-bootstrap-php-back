<template>
    <div v-if='this.fields'>
        <div class='container-fluid p-0' v-for="field in this.fields" :key="field.num_field">
            <div v-if="field.hidden == '0'">
            <Input v-if='field.type_field == "PHONE" || field.type_field == "STRING" || field.type_field == "INT"
            || field.type_field == "DECIMAL" || field.type_field =="MONTH_YEAR"
            || field.type_field =="PHONE" || field.type_field == "AMOUNT" || field.type_field == "BIC"'
                type='text' :label='field.rus_name' 
                :id='field.num_field' :hint='field.hint'
                :dataValue='this.values[field.num_field]'
                @updateParentState="this.setValue"
            />
            <Switch v-if='field.type_field == "BOOL"'
                :label='field.rus_name' 
                :id='field.num_field' :hint='field.hint'
                :dataValue='this.values[field.num_field]'
                @updateParentState="this.setValue"
            />
            <Select v-if='field.list == "1"'
                :label='field.rus_name' 
                :id='field.num_field' :hint='field.hint'
                :keywords='this.getKeywords(field)'
                :dataValue='this.values[field.num_field]'
                @updateParentState="this.setValue"
            />
            <InputDate v-if='field.type_field == "DATE"'
                :id='field.num_field'
                :label='field.rus_name' :hint='field.hint'
                :dataValue='this.values[field.num_field]'
                @updateParentState="this.setValue"
            />
            <InputDate v-if='field.type_field == "TIME"'
                :id='field.num_field'
                :label='field.rus_name' :hint='field.hint'
                :dataValue='this.values[field.num_field]'
                type='time'
                @updateParentState="this.setValue"
            />
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Switch from '@/components/service/Switch';
import Select from '@/components/service/Select';
import InputDate from '@/components/service/InputDate';

export default {
    components: {
        Input,
        Switch,
        Select,
        InputDate
    },
    data() {
        return {
            values: this.getValues(this.dataValues),
        }
    },
    props: {
        fields: [Boolean, Object],
        dataValues: [Boolean, Object],
    },
    methods: {
        setValue(arg) {
            this.$emit('updateParentState', {
                id: arg.id,
                value: arg.value
            })
        },
        getValues(obj) {
            let res = {}
            for (let key in obj) {
                res[key] = obj[key] ? obj[key] : '';
            }
            return res
        },
        getKeywords(field) {
            if (field.lists) {
                return field.lists;
            } else {
                let codes = field.type_num_val.split('|');
                let vals = field.type_text_val.split('|');
                let arr = [];
                for (let i = 0; i < codes.length; i++) {
                    arr.push({'code': codes[i], 'value': vals[i]})
                }
                return arr;
            }
        }
    },
    mounted() {
    },

}
</script>