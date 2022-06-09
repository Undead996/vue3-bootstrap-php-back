<template>
    <div class=''>
        <div>
            <div class="row container-fluid g-3 p-0">
                <h5>Настройка доступа по IP-адресу не позволит Вам (или злоумышленнику) работать с системой с адреса, не прописанного в списке разрешённых.</h5>
            </div> 
            <div class="row container-fluid p-0 g-3">
                <SwitchSimple v-if="this.data.ip_data" class='pl-4' label='Ограничение доступа к кабинету по IP-адресам' :dataValue.sync='this.data.ip_status' type='form-switch-xl' id='ip_status' @updateParentState="this.updateState"/>
            </div>
        </div>
        <div v-if="this.data.ip_status">
        <div class="main-title container-fluid p-0">
            <h1>Добавить адреса</h1>
        </div>
        <div class = 'content p-4'>
            <div class="input-group mt-2 g-3 p-0 input">
                <div class="col-lg-3 col-sm-2 col-12">
                    <label class="col-form-label input-label">Адрес: </label>
                </div>
                <div class="col-lg-7 col-sm-8 col-12 pr-1 input-wrapper">
                    <InputSimple id="add_ip" :class="{ invalid: this.warn.ip }" @updateParentState="this.addValue"/>
                    <div v-if="this.warn.ip" class="invalid-feedback">
                        {{this.warn.ip}}
                    </div>
                </div>
                <div class="col-lg-1 col-sm-1 col-12 input-wrapper text-end" :class="{'btn_mb': this.$store.state.resize.w < 576}">
                    <Button name='Добавить' type='btn-outline-warning' v-on:click="() => {this.addNewIp(this.add_ip)}"/>
                </div>
            </div>
            <div class="input-group mt-3 g-3 p-0 input">
                <div class="col-lg-3 col-sm-2 col-12">
                    <label class="col-form-label input-label">Блок адресов: </label>
                </div>
                <div class="row m-0 col-lg-7 col-sm-8 col-12 pr-1">
                    <label class="col-form-label col-1 pl-0 input-label text-end">c:</label>
                    <div class="col input-wrapper">
                        <InputSimple id="addr_start" :class="{ invalid: this.warn.start }" @updateParentState="this.addGroupValue"/>
                        <div v-if="this.warn.start" class="invalid-feedback">
                            {{this.warn.start}}
                        </div>
                    </div>
                    <label class="col-form-label col-1 pl-0 input-label text-end">по:</label>
                    <div class="col pr-0 input-wrapper">
                        <InputSimple id="addr_end" :class="{ invalid: this.warn.end }" @updateParentState="this.addGroupValue"/>
                        <div v-if="this.warn.end" class="invalid-feedback">
                            {{this.warn.end}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-sm-1 col-12 input-wrapper text-end" :class="{'btn_mb': this.$store.state.resize.w < 576}">
                    <Button name='Добавить' type='btn-outline-warning' v-on:click="() => {this.addNewIps(this.group_ip)}"/>
                </div>
            </div>
            <div class="input-group mt-3 g-3 p-0 align-items-center input">
                <div class="col-lg-3 col-sm-2 col-12">
                    <label class="col-form-label input-label">Свой IP: </label>
                </div>
                <div class="col-lg-7 col-sm-8 col-12 input-wrapper">
                    <span>{{this.self_ip}}</span>
                </div>
                <div class="col-lg-1 col-sm-1 col-12 input-wrapper text-end" :class="{'btn_mb': this.$store.state.resize.w < 576}">
                    <Button name='Добавить' type='btn-outline-warning' v-on:click="() => {this.addNewIp(this.self_ip)}"/>
                </div>
            </div>
        </div>
        <div class="main-title container-fluid p-0">
            <h1>Список адресов</h1>
        </div>
        <div v-if="this.data.ip_status" class = 'content p-4 table-responsive'>
            <table class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">С адреса</th>
                        <th scope="col">По адрес</th>
                        <th scope="col">Доступ</th>
                        <th class="text-end" scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody v-if="Object.keys(this.data.ip_data).length">
                    <tr v-for="(row, index) in this.data.ip_data" :key="row.index">
                        <td class="align-middle" scope="col">{{index}}</td>
                        <td class="align-middle" scope="col">{{row.addr_start}}</td>
                        <td class="align-middle" scope="col">{{row.addr_end}}</td>
                        <td class="align-middle" scope="col"><SelectSimple :dataValue.sync='row.enable' :id='index.toString()' :keywords.sync='this.keywords' @updateParentState="this.setSelectValue"/></td>
                        <td class="align-middle text-end" scope="col"><Button name='Удалить' type='btn-outline-warning btn-sm' v-on:click="() => {this.delValue(index)}"/></td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="5">Адреса отсутствуют</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <div class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.confirmSettings"/>
            </div>
        </div>

    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Button from '@/components/service/Button';
import SwitchSimple from '@/components/service/SwitchSimple';
import SelectSimple from '@/components/service/SelectSimple';
import InputSimple from '@/components/service/InputSimple';
import lib from '@/includes/lib.js';

export default {
    components: {
        Input,
        Button,
        SwitchSimple,
        SelectSimple,
        InputSimple
    },
    data() {
        return {
            data: {
                ip_status: false,
                ip_data: false
            },
            self_ip: '',
            add_ip: '',
            group_ip: {'addr_start': '', 'addr_end': ''},
            warn: {
                ip: false,
                start: false,
                end: false,
            },
            keywords: [{'code': '0', value: 'Запретить'},
                       {'code': '1', value: 'Разрешить'}],
            ready: false,
        }
    },

    methods: {
        setSelectValue(state) {
            this.data.ip_data[state.id].enable = state.value;
        },
        addValue(state) {
            this.add_ip = state.value;
        },
        addGroupValue(state) {
            this.group_ip[state.id] = state.value;
        },
        delValue(index) {
            delete this.data.ip_data[index];
        },
        addNewIp(ip) {
            if (this.checkIp(ip, 'ip')) {
                if (!Object.keys(this.data.ip_data).length) {
                    this.data.ip_data = {'1': {'addr_start': ip, 'addr_end':ip, 'enable': '1'}}
                } else {
                    this.data.ip_data[Object.keys(this.data.ip_data).length + 1] = {'addr_start': ip, 'addr_end':ip, 'enable': '1'}
                }
            }
        },
        addNewIps(ip) {
            if (this.checkIp(ip['addr_start'], 'start') && this.checkIp(ip['addr_end'], 'end')) {
                if (!Object.keys(this.data.ip_data).length) {
                    this.data.ip_data = {'1': {'addr_start': ip['addr_start'], 'addr_end':ip['addr_end'], 'enable': '1'}}
                } else {
                    this.data.ip_data[Object.keys(this.data.ip_data).length + 1] = {'addr_start': ip['addr_start'], 'addr_end':ip['addr_end'], 'enable': '1'}
                }
            }
        },
        confirmSettings() {
            if (this.checkForm()) {
                let data = {
                    'status': '1',
                    'ip_access': this.CreateIpString(),
                }
                this.axios.post('setAccessIpStatus', {data: data});
            }
        },
        updateState(state) {
            this.data[state.id] = state.value;
        },
        CreateIpString() {
            var s = new String();
            let IpList = Object.keys(this.data.ip_data);
            if (!this.data.ip_status) {
                s += '0.0.0.0-255.255.255.255:1';
                if (IpList.length > 0)
                    s += ';';
            }
            for (let i = 0; i < IpList.length; i++) {
                s += this.data.ip_data[IpList[i]].addr_start;
                if (this.data.ip_data[IpList[i]].addr_start != this.data.ip_data[IpList[i]].addr_end)
                    s += "-" + this.data.ip_data[IpList[i]].addr_end;
                s += ":" + this.data.ip_data[IpList[i]].enable.toString();
                if (i != IpList.length - 1)
                    s += ";";
            }
            return s;
        },
        checkIp(ip, sel) {
            if (ip == '') {
                this.warn[sel] = "Введите IP-адрес";
                // lib.alertE(this.$store, {'result': '1', 'result_text': 'Введите IP-адрес'});
                return false;
            }
            if (!this.isCorrectIP(ip)) {
                this.warn[sel] = "IP-адрес введен неверно";
                // lib.alertE(this.$store, {'result': '1', 'result_text': 'IP-адрес введен неверно'});
                return false;
            }
            this.warn[sel] = false;
            return true;
        },
        isCorrectIP(Value) {
            if (Value == null || Value == '')
                return false;
            var Blocks = Value.split('.');
            if (Blocks.length != 4)
                return false;
            for (let i = 0; i < Blocks.length; i++) {
                if (!lib.isInt(Blocks[i]))
                    return false;
                if (parseInt(Blocks[i]) < 0 || parseInt(Blocks[i]) > 255)
                    return false;
            }
            return true;
        },
        checkForm() {
            if (this.data.ip_status) {
                let IpList = Object.keys(this.data.ip_data);
                if (IpList.length <= 0) {
                    lib.alertE(this.$store, {'result': '1', 'result_text': 'Не указан ни один IP-адрес или блок адресов.'});
                    return false;
                }
                let activeCC = 0;
                for (let i = 0; i < IpList.length; i++) {
                    if (this.data.ip_data[IpList[i]].enable == '1') {
                        activeCC += 1;
                    }
                }
                if (activeCC <= 0) {
                    lib.alertE(this.$store, {'result': '1', 'result_text': 'Ни один IP-адрес не разрешен для авторизации. Вы не сможете получить доступ к своему счету.'});
                    return false;
                }
            }
            return true;
        }
    },
    created() {
        this.$store.commit('TITLE', 'Доступ по IP');
        this.axios.post('getAccessIpStatus').then(res => {
            this.data.ip_data = res.data.body[1]
            this.data.ip_status = res.data.body[0]
            this.self_ip = res.data.body[2]})
    },
}
</script>