<template>
  <div class='container-xl container-fluid pb-5'>
    <Title/>
    <div class = 'pb-4'>
        <div class="input-group g-3 p-0 input align-items-center justify-content-between">
            <div class="d-flex col-lg-4 col-12 flex-wrap align-items-center justify-content-start">
                <div class='d-flex col-5 mt-2 g-3 align-items-center justify-content-start'> 
                    <InputDateSimple class='col-12' id='date_start' :dataValue='this.fields.date_start' placeholder='Период с' @updateParentState="this.updateState" :max='new Date()'/>
                </div>
                <div class='col-1 mt-2 d-block text-center'>
                    &#8212;
                </div>
                <div class='d-flex mt-2 col-5 g-3 pr-1 align-items-center justify-content-start'> 
                    <InputDateSimple class='col-12' id='date_end' :dataValue='this.fields.date_end' placeholder='Период по' @updateParentState="this.updateState" :max='new Date()'/>
                </div>
                <div class='mt-2 col-1 col-sm-1 d-flex justify-content-start'>
                    <Dropdown class='w-100' :menu='this.dataDropMenu' :position='"right lg-left"' :style='"padding: 6px;"' label=''/>
                </div>
            </div>
            <div class="d-flex col-lg-7 col-xl-6 flex-wrap col-12 justify-content-between">
                <Button name="Экспорт" class='mt-2' :class='{"w-23" : this.$store.state.resize.w > 520, "w-45" : this.$store.state.resize.w < 521}' :style='"min-width: 114px;"' icon_i='download' :disabled='Object.keys(this.data).length == 0 ? true : false' v-on:click='this.export' type='btn-outline-warning btn'/>
                <Button name='Фильтры' class='mt-2' :class='{"w-23" : this.$store.state.resize.w > 520, "w-45" : this.$store.state.resize.w < 521}' :style='"min-width: 108px;"' v-on:click='this.showFilters' :type='this.sfilters ? "btn-warning" : "btn-outline-warning"'/>
                <Button name='Сбросить' class='mt-2' :class='{"w-23" : this.$store.state.resize.w > 520, "w-45" : this.$store.state.resize.w < 521}' :style='"min-width: 108px;"' v-on:click='this.clearFilters' type='btn-outline-warning'/>
                <Button name='Обновить' class='mt-2' :class='{"w-23" : this.$store.state.resize.w > 520, "w-45" : this.$store.state.resize.w < 521}' :style='"min-width: 108px;"' v-on:click="this.updateHistory" type='btn-warning'/>
            </div>
        </div>
        <div v-if="this.sfilters" class="input-group g-3 p-0 align-items-center justify-content-between">
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between">
                    <SelectSimple id='code' :dataValue='this.fields.code' @updateParentState="this.updateState" :keywords.sync='this.keywords1'/>
            </div>
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between" :class='{"pl-2": this.$store.state.resize.w > 769}'>
                    <SelectSimple class='mr-1' id='pre_sum' @updateParentState="this.updateReq" :dataValue='this.req.pre_sum' :keywords.sync='this.keywords3'/>
                    <InputSimple id='sum' placeholder='Сумма' :dataValue='this.fields.sum' @updateParentState="this.updateState"/>
            </div>
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between" :class='{"pl-2": this.$store.state.resize.w > 769}'>
                    <SelectSimple id='typelocal' :dataValue='this.fields.typelocal' @updateParentState="this.updateState" :keywords.sync='this.keywords2'/>
            </div>
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between">
                    <InputSimple id='transact_num' placeholder='№ транзакции' :dataValue='this.fields.transact_num' @updateParentState="this.updateState"/>
            </div>
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between" :class='{"pl-2": this.$store.state.resize.w > 769}'>
                    <SelectSimple id='done' :dataValue='this.fields.done' @updateParentState="this.updateState" :keywords.sync='this.keywords4'/>
            </div>
            <div class="col-md-4 col-12 d-flex g-3 p-0 mt-2 align-items-center justify-content-between" :class='{"pl-2": this.$store.state.resize.w > 769}'>
                <InputSimple id='param' placeholder='Параметр' :dataValue='this.fields.param' @updateParentState="this.updateState"/>
            </div>
        </div>
    </div>
    <div class = 'content p-4'>
        <div v-if="Object.keys(this.data).length != 0" class='table-responsive'>
        <table class="table table-borderless table-striped neue-roman">
            <thead>
                <tr>
                    <th scope="col">Тип</th>
                    <th scope="col">Транзакция</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Операция</th>
                    <th scope="col">Корреспондент</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Параметры/Комментарий</th>
                </tr>
            </thead>
            <tbody class=''>
                <tr v-for="(row, index) in this.content" :key="index">
                    <td class="align-middle" scope="col"><i class='item-i' :class="{'plus': row.typelocal == 'Приход', 'minus': row.typelocal == 'Расход', 'repeat': row.typelocal == '-'}"></i></td>
                    <td class="align-middle href" scope="col" v-on:click='() => {this.showParams(row.transact)}'>{{row.transact}}</td>
                    <td class="align-middle" scope="col">{{row.date}}</td>
                    <td class="align-middle" scope="col">{{row.code_text}}</td>
                    <td class="align-middle" scope="col">{{row.pay_name}}</td>
                    <td class="align-middle" scope="col">{{row.sum}}<br><span class='grey'>{{row.curr}}</span></td>
                    <td class="align-middle" scope="col">
                        <SlotPopper :content="row.result" placement='bottom'>
                            <i class='item-i' :class="{'check': row.done == '1', 'x_red': row.done == '-2', 'rollback': row.done == '3', 'clock': row.done == '0'}"></i>
                        </SlotPopper>
                    </td>
                    <td class="align-middle" scope="col">
                        <p class='m-0' v-if='row.param'>{{row.param}}: {{row.param_value}}</p>
                        <p class='m-0' v-if='row.comment'>{{row.comment}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <div v-else class='mt-2 grey text-center'>
            <h5>Операций не найдено</h5>
        </div>
    </div>
    <div class="d-flex container-fluid g-3 align-items-center justify-content-center">
        <Pagination class='col-sm-3' :data.sync='this.data' @updateContentState="this.updateContent"/>
    </div>
    <div v-if='this.summary' class="row container-fluid g-3 mt-2 p-0">
        <h3>Сумма операций</h3>
    </div> 
    <div v-if='this.summary' class='d-flex container-fluid neue-roman flex-wrap p-0 g-3 align-items-center justify-content-between'>
        <div class='col-sm-5 col-12 content p-4'>
            <h5 class='income'>Поступления:</h5>
            <div>
                <div v-for="(row, index) in this.summary" :key="index">
                    <span>{{row.income_ok_cc}} шт. на сумму</span> <span class='income'>{{row.income_ok}}</span> <span class='grey'>{{index}}</span>
                </div>
            </div>
        </div>
        <div class='col-sm-5 col-12 content p-4'>
            <h5 class='outcome'>Расходы:</h5>
            <div>
                <div v-for="(row, index) in this.summary" :key="index">
                    <span>{{row.outcome_ok_cc}} шт. на сумму</span> <span class='outcome'>{{row.outcome_ok}}</span> <span class='grey'>{{index}}</span>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import Title from '@/components/service/Title';
import Button from '@/components/service/Button';
import Dropdown from '@/components/service/Dropdown';
import Pagination from '@/components/service/pagination/Pagination';
import InputDateSimple from '@/components/service/InputDateSimple';
import SelectSimple from '@/components/service/SelectSimple';
import InputSimple from '@/components/service/InputSimple';
import SlotPopper from '@/components/service/SlotPopper';

export default {
    components: {
        InputDateSimple,
        SelectSimple,
        Button,
        Title,
        Pagination,
        InputSimple,
        SlotPopper,
        Dropdown
    },
    data() {
        return {
            content: {}, 
            data: {},
            keywords1: [
                        {'code': '-1', value: 'Тип операций', place: true},
                        {'code': '51013', value: 'Моментальная оплата'},
                        {'code': '52013,52023,52063', value: 'Перевод пользователю'},
                        {'code': '35103,35123,35133', value: 'Оплата счета'},
                        {'code': '50123', value: 'Перевод по своим счетам'},
                        {'code': '53104', value: 'Создание электронных чеков'},
                        {'code': '53103', value: 'Активация электронных чеков'},
                        {'code': '-52013,-52023,-52063,-51013,-35103,-35123,-35133,-50123,-53104,-53103', value: 'Прочее'},
            ],
            keywords2: [
                        {'code': '-1', value: 'Приход/расход', place: true},
                        {'code': '1', value: 'Приход'},
                        {'code': '2', value: 'Расход'},
            ],
            keywords3: [
                        {'code': '=', value: 'равно'},
                        {'code': '<>', value: 'НЕ равно'},
                        {'code': '>', value: 'больше'},
                        {'code': '>=', value: 'больше или равно'},
                        {'code': '<', value: 'меньше'},
                        {'code': '<=', value: 'меньше или равно'},
            ],
            keywords4: [{'code': 'false', value: 'Статус', place: true},
                        {'code': '1', value: 'Успешно завершена'},
                        {'code': '0,4,5', value: 'В обработке'},
                        {'code': '-2,-3', value: 'Ошибка' }
            ],
            dataDropMenu: [
                {name: 'Сегодня', handler: () => {this.dateSelect(new Date(), new Date())}},
                {name: 'Вчера', handler: () => {this.dateSelect(this.DateSet(-1), this.DateSet(-1))}},
                {name: 'Неделя', handler: () => {this.dateSelect(this.DateSet(-7), new Date())}},
                {name: 'Месяц', handler: () => {this.dateSelect(this.DateSet(-30), new Date())}},
                {name: 'Год', handler: () => {this.dateSelect(this.DateSet(-365), new Date())}},
            ],
            fields: {
                date_start: false,
                date_end: false,
                code: '-1',
                typelocal: '-1',
                sum: false,
                transact_num: false,
                done: 'false',
                param: false,
            },
            req: {
                pre_sum: '=',
            },
            sfilters: false,
            summary: false
        }
    },
    created() {
        this.$store.commit('TITLE', 'История операций');
    },
    mounted() {
        // this.updateHistory();
    },
    methods: {
        updateContent(arg) {
            this.content = arg;
        },
        dateSelect(datef, datet ) {
            this.fields.date_start = datef.toISOString().split('T')[0];
            this.fields.date_end = datet.toISOString().split('T')[0];
            this.updateHistory();
        },
        DateSet(e) {
            let n = new Date;
            n.setDate(n.getDate() + e);
            return n;
        },
        updateState(state) {
            this.fields[state.id] = state.value;
            if (state.id == 'date_start' && this.fields['date_end'] || state.id == 'date_end' && this.fields['date_start']) {
                this.updateHistory();
            } else if (state.id == 'done' || state.id == 'typelocal' || state.id == 'code' ) {
                this.updateHistory();
            }
        },
        updateReq(state) {
            this.req[state.id] = state.value;
        },
        showFilters() {
            this.sfilters = !this.sfilters;
        },
        clearFilters() {
            this.fields.code = '-1';
            this.fields.typelocal = '-1';
            this.fields.sum = false;
            this.fields.transact_num = false;
            this.fields.done = 'false';
            this.fields.param = false;
            this.sfilters = false;
            this.updateHistory();
        },
        showParams(key) {
            this.axios.post('GetParamsFinoperationLight', {data: {transact_num: key}}).then(res => {
                this.$store.commit('MODAL', {
                                        action: true,
                                        type: 'history',
                                        content: res.data.body,
                                        }
                                );
            })
        },
        export() {
            let query = JSON.stringify(this.checkData());
	        window.location.href = "ExportHistory?data=" + query;
        },
        checkData() {
            let params = {};
            for(let key in this.fields) {
                if (this.fields[key] != false && this.fields[key] != 'false') {
                    if (key == 'sum') {
                        params[key] = this.req.pre_sum + this.fields[key]
                    } else {
                        params[key] = this.fields[key];
                    }
                }
            }
            return params;
        },
        updateHistory() {
            this.axios.post('GetFinoperationLight', {data: this.checkData()}).then(res => {
                const INCOMPLETE = 0;
                const COMPLETION = 1;
                const REFUSED_WIRING = 2;
                const COMPLETION_WIRING_RE_ENTRY = 3;
                const REFUSED = -2;
                const REFUSED_OLD = -1;
                const COMPLETION_WIRING = -3;
                const ANNULMENT = -3;
                const DETAINEES = 4;
                const BLOCKED = 5;

                var COMPLETION_ALL = [
	                COMPLETION, REFUSED_WIRING
                ];

                var INCOMPLETE_ALL = [
	                INCOMPLETE, DETAINEES, BLOCKED
                ];

                var REFUSED_ALL = [
	                REFUSED_OLD, REFUSED, COMPLETION_WIRING, ANNULMENT
                ];
                let data = res.data.body;
                let summary = {};
                for (let i = 0; i < data.length; i++) {
                    let row = data[i];
                    if (!(row['curr'] in summary)) {
			            summary[row['curr']] = {};
			            summary[row['curr']].income_ok = 0;
			            summary[row['curr']].income_ok_cc = 0;
			            summary[row['curr']].income_inprocess = 0;
			            summary[row['curr']].income_inprocess_cc = 0;
			            summary[row['curr']].outcome_ok = 0;
			            summary[row['curr']].outcome_ok_cc = 0;
			            summary[row['curr']].outcome_inprocess = 0;
			            summary[row['curr']].outcome_inprocess_cc = 0;

			            // summary[row['curr']].precision = HardcodeCurrPrecision(row['curr'], row['sum']);
                    }

                    if (row['typelocal'] == 'Расход') { // расход
			            if (row['done'] == 0 || row['done'] == INCOMPLETE_ALL) {
				            summary[row['curr']].outcome_inprocess_cc += 1;
				            summary[row['curr']].outcome_inprocess += parseFloat(row['sum']) || 0;
			            }
			            else if (row['done'] == COMPLETION) {
				            summary[row['curr']].outcome_ok_cc += 1;
				            summary[row['curr']].outcome_ok += parseFloat(row['sum']) || 0;
			            }
		            } else if (row['typelocal'] == 'Приход') { // приход
			            if (row['done'] == 0 || row['done'] == INCOMPLETE_ALL) {
				            summary[row['curr']].income_inprocess_cc += 1;
				            summary[row['curr']].income_inprocess += parseFloat(row['sum']) || 0;
			            }
			            else if (row['done'] == COMPLETION) {
				            summary[row['curr']].income_ok_cc += 1;
				            summary[row['curr']].income_ok += parseFloat(row['sum']) || 0;
			            }
		            } else if (row['typelocal'] == '-') { 
			            if (row['done'] == 0 || row['done'] == INCOMPLETE_ALL) {
				            summary[row['curr']].income_inprocess_cc += 1;
				            summary[row['curr']].income_inprocess += parseFloat(row['sum']) || 0;
                            summary[row['curr']].outcome_inprocess_cc += 1;
				            summary[row['curr']].outcome_inprocess += parseFloat(row['sum']) || 0;
			            }
			            else if (row['done'] == COMPLETION) {
				            summary[row['curr']].income_ok_cc += 1;
				            summary[row['curr']].income_ok += parseFloat(row['sum']) || 0;
                            summary[row['curr']].outcome_ok_cc += 1;
				            summary[row['curr']].outcome_ok += parseFloat(row['sum']) || 0;
			            }
		            }
                }
                this.summary = Object.keys(summary).length == 0 ? false : summary;
                this.data = data;
            });
        }
    },
}
</script>

<style lang="scss">
.income {
    color: $color-menu;
}
.w-23 {
    width: 23%;
}
.w-45 {
    width: 47%;
}
.outcome {
    color: $color-acent;
}
</style>