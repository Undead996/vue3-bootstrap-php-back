<template>
    <div>
        <div class='d-flex justify-content-between'>
            <h2>{{this.content[1].typelocal == '-' ? 'Приход/Расход' : this.content[1].typelocal}}, транзакция {{this.content[1].transact}}</h2>
            <i class='big item-i x_red' v-on:click='this.close'></i>
        </div>
        <div class='container-fluid mt-1 p-0 g-3'>
            <h4 class='p-0 mt-4 color-menu'>Общие параметры</h4>
            <div class='d-flex p-0 container-fluid align-items-start justify-content-between'
            v-for="(row, index) in this.content[0][0][0]['colvalues']" :key="index">
                <div v-if='index != "0"' class='col-4 p-0 grey'>{{row.param}}:</div>
                <div v-if='index != "0"' class='col-7 p-0' :class="{'neue-bold':index == '1' || index == '4' }">{{row.value}}</div>
            </div>

            <h4 class='p-0 mt-4 color-menu'>Баланс счета {{this.content[1]['keyt']}}</h4>
            <div class='d-flex p-0 container-fluid align-items-start justify-content-between'>
                <div class='col-4 p-0 grey'>На начало операции:</div>
                <div class='col-7 p-0'>{{this.content[1]['balance_start']}} {{this.content[1].curr}}</div>
            </div>
            <div class='d-flex p-0 container-fluid align-items-start justify-content-between'>
                <div class='col-4 p-0 grey'>На конец операции:</div>
                <div class='col-7 p-0'>{{this.content[1]['balance_end']}} {{this.content[1].curr}}</div>
            </div>

            <h4 v-if="this.content[0][0]['colvalues'].length" class='p-0 mt-4 color-menu'>Дополнительные параметры</h4>
            <div class='d-flex p-0 container-fluid align-items-start justify-content-between'
            v-for="(row, index) in this.content[0][0]['colvalues']" :key="index">
                <div class='col-4 p-0 grey'>{{row.param}}:</div>
                <div class='col-7 p-0'>{{row.value}}</div>
            </div>
        </div>
        <div v-if='this.save_t'>
            <h4 class='p-0 mt-4 color-menu'>Параметры шаблона</h4>
            <div class='d-flex p-0 pr-0 container-fluid align-items-center justify-content-between'>
                <div class='col-sm-4 p-0 grey'>Название шаблона :</div>
                <div class='col-sm-7 p-0 mt-1 d-flex flex-wrap container-fluid align-items-center justify-content-between'>
                    <div class="col-sm-8 p-0"><InputSimple id="template_name"  @updateParentState="this.updateState"/></div>
                    <div class="p-0 d-flex justify-content-end"><Button name='Сохранить' type='btn-outline-warning' v-on:click='this.saveTemplate'/></div>
                </div>
            </div>
        </div>
        <div class='d-flex mx-auto justify-content-center flex-wrap pt-3'>
            <Button v-if='+this.content[1].repealing == 1' name='Отменить операцию' class='ml-2 mt-2' type='btn-outline-warning' v-on:click='this.cancelPayment'/>
            <Button v-if="this.content[1]['code_cmd'] == 'pay_momental' || this.content[1]['code_cmd'] == 'pay_from_gate' || this.content[1]['code_cmd'] == 'pay_id' || this.content[1]['code_cmd'] == 'merchant_purchase'"
             name='Повторить операцию' class='ml-2 mt-2' type='btn-outline-warning' v-on:click='this.close'/>
            <Button  v-if="this.content[1]['code_cmd'] == 'pay_momental' || this.content[1]['code_cmd'] == 'pay_from_gate' || this.content[1]['code_cmd'] == 'pay_id' || this.content[1]['code_cmd'] == 'merchant_purchase'" 
             name='Сохранить шаблон' class='ml-2 mt-2' type='btn-outline-warning' v-on:click='() => {this.save_t = !this.save_t}'/>
            <Button name='Закрыть' class='ml-2 mt-2' type='btn-warning' v-on:click='this.close'/>
        </div>
        
    </div>
</template>

<script>
import Button from '@/components/service/Button';
import InputSimple from '@/components/service/InputSimple';
import lib from '@/includes/lib.js';

export default {
    components: {
        Button,
        InputSimple
    },
    props: {
        close: [Function],
    },
    data () {
        return {
            content: this.$store.state.modal.content,
            data: {
                template_name: '',
            },
            save_t: false,
        }
    },
    methods: {
        updateState(state) {
            this.data[state.id] = state.value;
        },
        cancelPayment() {
            this.$store.commit('MODAL', {
                action: true,
                type: 'pay_pass',
                content: {callback: () => {
                    this.axios.post('CancelPayment', {data: {'transact': this.content[1].transact}})}
                },
            });
        },
        saveTemplate() {
            if (this.content[1]['code_cmd'] == 'pay_id') {
		        let params = {};
	            params['keyt'] = this.content[1]['keyt'];
	            params['corr_keyt'] = this.content[1]['keyt_shop'];
	            params['corr_id'] = this.content[1]['id_corr'];
	            params['corr_name'] = this.content[1]['name_corr'];
	            params['curr'] = this.content[1]['curr'];
	            params['template_name'] = this.data.template_name;
	            params['comment'] = this.content[1]['comment'];
	            params['sum'] = this.content[1]['itogo'];
                this.axios.post('CreateTransferTemplate', {data: params})
            } else {
		        let precision = lib.HardcodeCurrPrecision(this.content[1]['curr'], this.content[1]['itogo']);

		        let params = {} ;
		        params['template_name'] = this.data.template_name;
		        params['comment'] = this.content[1]['comment'];
		        params['payform'] = this.content[1]["subj_param"];
		        params['sum'] = ((+this.content[1]['itogo'].split(' ')[0]).toFixed(precision) - (+this.content[1]['comiss'].split(' ')[0]).toFixed(precision)).toFixed(precision);
		        params['keyt'] = this.content[1]['keyt'];

		        var fields = this.content[0][0]['colvalues'];
		        for (let i = 1, il = fields.length; i <= il; i++) {
			        params[i] = fields[i - 1] ? fields[i - 1].value : '';
		        }
                this.axios.post('SaveCatalogTemplate', {data: params});	        
            }

            this.save_t = !this.save_t;
        }
    },
}
</script>

<style lang="scss" scoped>
    h4 {
        font-family: 'HelveticaNeue' !important;
    }
    .big {
        background-size: contain;
        cursor: pointer;
    }
</style>