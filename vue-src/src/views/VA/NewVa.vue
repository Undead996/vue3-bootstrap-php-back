<template>
    <div class=''>
    <ColumnStages v-if="this.$store.state.isMobile" @updateParentState="this.updateStage" @updateShowContent="this.sContent" :stage='this.stage' :stages='this.stages' :showContent='this.showContent'/>
    <div v-if="this.showContent" class='content p-4' :class='{mobile: this.$store.state.isMobile}'>
        <Stages v-if="!this.$store.state.isMobile" @updateParentState="this.updateStage" :stage='this.stage' :stages='this.stages'/>
        <div v-if="this.stage == 0">
            <Input type='text' :dataValue='this.data.name' label="Название:" :require="true" id='name' @updateParentState="this.updateState" hint='Название – это полное название виртуального актива, каким его будут видеть все: сам эмитент, покупатели, продавцы, процессинг и др. Строка длиной не более 40 символов'/>
            <Input type='text' :dataValue='this.data.ticker' label="ТИКЕР:" :require="true" id='ticker' @updateParentState="this.updateState" hint='Тикер – это короткое название виртуального актива, сокращенная аббревиатура длиной от 3 до 10 символов'/>
            <Select label="Категория:" :dataValue='this.data.category' :require="true" id='category' :keywords.sync='this.keywords' @updateParentState="this.updateState" hint='Выберите категорию, к которой больше подходит ваш виртуальный актив'/>
            <File label='Логотип:' :dataValue='this.data.logo' id='logo' @updateParentState="this.updateState" hint='Поддерживаемые форматы: png, jpg, jpeg. Размер файла не более 1 Мб, 500*500 пикселей'/>
            <Input type='textarea' :dataValue='this.data.mission' label="Цель / миссия / назначение:" id='mission' @updateParentState="this.updateState" hint='Опишите, зачем данный актив выпускается эмитентом, в какой сфере работает или будет работать, какова его миссия'/>
        </div>
        <div v-if="this.stage == 1">
            <Number label="Точность:" :dataValue='this.data.precision' :require="true" id='precision' @updateParentState="this.updateState"/>
            <Number label="Первичная эмиссия:" :dataValue='this.data.first_emission' id='first_emission' @updateParentState="this.updateState"/>
            <Number label="Максимальная эмиссии:" :dataValue='this.data.max_emission' id='max_emission' @updateParentState="this.updateState"/>
            <Select label="Стоимость единицы:" :dataValue='this.requires.single_amount' id='single_amount' :keywords.sync='this.keywords2' @updateParentState="this.updateReq"/>
            <div v-if='this.requires.single_amount == "1"' class="row container-fluid mt-1 p-0 g-3 align-items-center input">
                <div class="col-sm-3 p-0">
                    <label class="col-form-label input-label">Заявленная стоимость единицы:</label>
                </div>
                <div class="input-group col-sm-9 align-items-center justify-content-between input-wrapper w-75 p-0">
                    <div class='col-sm-2'>
                        <InputSimple id="bind_custom_count" :dataValue='this.data.bind_custom_count' @updateParentState="this.updateState"/>
                    </div>
                    <div class='col-sm-2'>
                        <InputSimple  id="duble" :dataValue='this.data.ticker' disabled />
                    </div>
                    =
                    <div class='col-sm-2'>
                        <InputSimple  id="bind_fiat_count" :dataValue='this.data.bind_fiat_count' @updateParentState="this.updateState"/>
                    </div>
                    <div class='col-sm-3'>
                        <SelectSimple  id='bind_fiat_curr' :dataValue='this.data.bind_fiat_curr' :keywords.sync='this.keywords6' @updateParentState="this.updateState"/>
                    </div>
                    <Popper class="bs-tooltip" content='some hint'/>
                </div>
            </div>
            <Number v-if='this.requires.single_amount == "1"' label="Обеспеченность:" :dataValue='this.data.cover_percent' id='cover_percent' @updateParentState="this.updateState"/>
            <Select v-if='parseInt(this.data.cover_percent) > 0' label="Счет:" :dataValue='this.data.cover_from_keyt' id='cover_from_keyt' :keywords.sync='this.keywords7' @updateParentState="this.updateState"/>
        </div>
        <div v-if="this.stage == 2">
            <Select label="Лицо, несущее обязательства:" id='responsible' :keywords.sync='this.keywords3' @updateParentState="this.updateState"/>
        </div>
        <div v-if="this.stage == 3">
            <Switch label="Экспортировать операции в блокчейн:" :dataValue='this.requires.block_chain' id='block_chain' @updateParentState="this.updateReq"/>
            <div v-if="this.requires.block_chain">
                <Select label="Тип блокчейна:" :dataValue='this.data.export_postings_form' id='export_postings_form' :keywords.sync='this.keywords5' @updateParentState="this.updateState"/>
                <GetInputs :fields='this.fields' :dataValues='this.export_postings_how_fields' @updateParentState="this.updateNumState"/>
            </div>
        </div>
        <!-- <div v-if="this.stage == 4">
            <Select type='text' label="Плательщик:" id='name' :keywords.sync='this.keywords4' @updateParentState="this.updateState"/>
        </div> -->
        <div v-if="this.stage == 4">
            <Switch label="Включить использование VA:" id='use_va' @updateParentState="this.updateState"/>
        </div>
        <div v-if="this.stage == 5">
            <Input type='text' label="Адрес на хостинге:" id='host' @updateParentState="this.updateState"/>
            <Input type='text' label="Адрес белой книги:" id='white_book' @updateParentState="this.updateState"/>
            <Input type='text' label="Электронная почта:" id='email' @updateParentState="this.updateState"/>
            <Input type='text' label="Telegram:" id='telegram' @updateParentState="this.updateState"/>
            <Input type='text' label="Twitter:" id='twitter' @updateParentState="this.updateState"/>
            <Input type='text' label="Facebook:" id='facebook' @updateParentState="this.updateState"/>
            <Input type='text' label="Другие контакты:" id='another' @updateParentState="this.updateState"/>
        </div>
    </div>
    <div v-if="!this.$store.state.isMobile" class='buttons-container'>
        <Button v-if="this.stage == 0" name='К предыдущему' type='btn-outline-warning' :disabled='true'/>
        <Button v-else name='К предыдущему' type='btn-outline-warning' v-on:click="() => {this.changeStage(-1)}"/>
        <Button v-if="this.ready" name='Сохранить' type='btn-warning' v-on:click="this.createVA"/>
        <Button v-else name='Сохранить' type='btn-warning' :disabled='true'/>
        <Button v-if="this.stage < 5" name='Далее' type='btn-outline-warning' v-on:click="() => {this.changeStage(+1)}"/>
        <Button v-if="this.stage == 5" name='Далее' type='btn-outline-warning' :disabled='true'/>
    </div>
    <div v-if="this.$store.state.isMobile" class='buttons-container'>
        <Button v-if="this.showContent" name='Далее' type='btn-outline-warning' :style="this.btnStyle" v-on:click="() => {this.sContent(false); this.$store.commit('TITLE', 'Размещение виртуального актива')}"/>
        <Button v-else name='Создать актив' type='btn-warning' :style="this.btnStyle" v-on:click="this.createVA"/>
    </div>
    </div>
</template>

<script>
import Stages from '@/components/virtAct/Stages';
import ColumnStages from '@/components/virtAct/ColumnStage';
import Input from '@/components/service/Input';
import InputSimple from '@/components/service/InputSimple';
import Select from '@/components/service/Select';
import SelectSimple from '@/components/service/SelectSimple';
import File from '@/components/service/File';
import Button from '@/components/service/Button';
import Switch from '@/components/service/Switch';
import Number from '@/components/service/Number';
import Popper from '@/components/service/Popper';
import GetInputs from '@/components/service/GetInputs';

export default {
    name: 'NewVA',
    components: {
        Input,
        InputSimple,
        Select,
        SelectSimple,
        File,
        Button,
        Stages,
        ColumnStages,
        Switch,
        Number,
        Popper,
        GetInputs
    },
    data() {
        return {
            stages: [
                {stage: 0, ready: false, name: 'Назавание и назначение'},
                {stage: 1, ready: false, name: 'Финансовые характеристики'},
                {stage: 2, ready: false, name: 'Эмитент'},
                {stage: 3, ready: false, name: 'Экспорт в блокчейн'},
                // {stage: 4, ready: false, name: 'Комиссии'},
                {stage: 4, ready: false, name: 'Лимиты и ограничения'},
                {stage: 5, ready: false, name: 'Контакты'},
            ],
            stage: 0,
            ready: false,
            keywords: [],
            keywords2: [{'code': '0', value: 'Не определена'},
                        {'code': '1', value: 'Жесткая привязка к фиатной валюте'}],
            keywords3: [{'code': '1', value: 'Я'},
                        {'code': '2', value: 'Никто не несет обязательств'}],
            keywords4: [{'code': '1', value: 'Отправитель'},
                        {'code': '2', value: 'Получатель'},
                        {'code': '3', value: 'Я (включить спонсорство)'}],
            keywords5: [{'code': '1', value: ''}],
            keywords6: [{'code': '0', value: ''}],
            keywords7: [
                {'code': '', value: ''}
            ],
            fields: [],
            export_postings_how_fields: {},
            data: {
                name: false,
                ticker: false,
                category: false,
                logo: false,
                mission: false,
                precision: false,
                first_emission: false,
                max_emission: false,
                cover_percent: false,
                cover_from_keyt: false,
                responsible: false,
                export_postings_form: false,
                commission_from_keyt: '',
                bind_custom_count: false,
                bind_fiat_count: false,
                bind_fiat_curr: false,
            },
            requires: {
                block_chain: false,
                single_amount: false,
            },
            sendData: {},
            showContent: true,
            btnStyle: 'font-size: 2rem; width: 100%; margin: 2rem 0;',
        }
    },
    created() {
        this.getKeywords();
        this.$store.commit('TITLE', 'Размещение виртуального актива')
        window.addEventListener('resize', this.checkSize);
    },
    methods: {
        getKeywords() {
            this.axios.post('GetKeywords', {group: '115'}).then(res => {this.keywords = res.data.body})
        },
        updateState(state) {
            this.data[state.id] = state.value;
            if (state.id == 'export_postings_form') {
                this.updateNumState('clear');
                this.axios.post('GetFormFields', {data: {payform: state.value}}).then(res => {this.fields = res.data.body})
            }
            if (state.id == 'cover_percent') {
                console.log(this.keywords7[0]['code'])
                if (parseInt(state.value) > 0 && !this.keywords7[0]['code'] ) {
                    this.axios.post('GetKeytsKeywords', {data: {}}).then(res => {this.keywords7 = res.data.body})
                } else if (parseInt(state.value) <= 0) {
                    this.keywords7 = [{'code': '', value: ''}];
                    this.data.cover_from_keyt = false;
                }
            }
            if (this.checkRequires()) {
                this.ready = true;
            } else {
                this.ready = false;
            }
        },
        updateNumState(state) {
            if (state == 'clear') {
                this.export_postings_how_fields = {};
                this.fields = [];
            } else {
                this.export_postings_how_fields[state.id] = state.value;
            }
        },
        updateReq(state) {
            this.requires[state.id] = state.value;
            if (state.id == 'block_chain' && state.value) {
                this.axios.post('GetSearchMomentalKeywords', {data: '20'}).then(res => {this.keywords5 = res.data.body})
            } else if (state.id == 'block_chain' && !state.value) {
                this.updateNumState('clear');
                this.data.export_postings_form = false;
            } else if (state.id == 'single_amount') {
                if (state.value == '1') {
                    this.axios.post('GetCurrKeywords', {}).then(res => {this.keywords6 = res.data.body});
                } else {
                    this.bind_custom_count = false;
                    this.bind_fiat_count = false;
                    this.bind_fiat_curr = false;
                    this.keywords6 = [{'code': '0', value: ''}];
                    this.keywords7 = [{'code': '', value: ''}];
                    this.data.cover_percent = false;
                    this.data.cover_from_keyt = false;
                }
            }
        },
        changeStage(i, s = this.stage) {
            if (s === false) {
                this.stage = false;
                return;
            }
            if (s + i < 0 || s + i > 5) {
                return;
            }
            if (this.stage > 1) {
                this.stages[this.stage].ready = true;
            } else if (this.stage == 0) {
                if (this.data.name != false && this.data.ticker != 0 && this.data.category != false) {
                    this.stages[0].ready = true;
                }
            } else if (this.stage == 1) {
                if (this.data.precision != false) {
                    this.stages[1].ready = true;
                }
            }
            this.stage = s + i;
        },
        updateStage(i) {
            this.changeStage(0, i)
        },
        sContent(b) {
            this.showContent = b;
        },
        createVA() {
            this.checkData();
            this.$store.commit('MODAL', {
                action: true,
                type: 'pay_pass',
                content: {callback: () => {
                    this.axios.post('NewVA', {data: this.sendData})}
                },
            });
        },
        checkData() {
            let params = {};
            this.data.export_postings_how_fields = this.export_postings_how_fields;
            for(let key in this.data) {
                if (this.data[key] !== false) {
                    params[key] = this.data[key];
                }
            }
            this.sendData = params;
        },
        checkRequires() {
            if (this.data.name && this.data.ticker && this.data.category && this.data.precision) {
                return true;
            }
        },
        checkSize() {
            this.showContent = !this.$store.state.isMobile;
        }
    },
}
</script>

<style lang="scss" scoped>
    .content.mobile {
        background: transparent;
        box-shadow: none;
        padding: 0;
    }
</style>