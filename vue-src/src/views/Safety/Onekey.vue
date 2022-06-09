<template>
    <div v-if="this.data" class=''>
        <div>
            <div class="row container-fluid g-3 p-0">
                <h5>Одноразовые ключи значительно повышают безопасность системы.</h5>
                <h5 class='my-1'>В момент входа программы вас попросят не только ввести логин и пароль, но и очередной одноразовый ключ. Активация производится поочередно. Последний ключ действует до момента, пока вы не создадите новую серию ключей.</h5>
            </div>
            <div class="row container-fluid p-0 g-3">
                <SwitchSimple label='Использовать одноразовые ключи' class='pl-4' :dataValue.sync='this.data.active' type='form-switch-xl' id='active' @updateParentState="this.updateState"/>
            </div>
        </div>
            <div class ='content p-4 mt-3'>
                <div class="d-flex container-fluid flex-wrap align-items-center justify-content-between g-3 p-0">
                    <div class='col-lg-3 col-md-4 col-12'>
                        <h3 class='my-1'>Список ключей</h3>
                    </div>
                    <div class="d-flex p-0 col-lg-6 col-12 col-md-8 g-3 flex-wrap align-items-center justify-content-between input">
                        <Button class="col-12 col-sm-4 my-1" name='Сгенерировать' v-on:click="this.gen_onekey" type='btn-warning btn'/>
                        <Button class="col-12 col-sm-4 my-1" name='Скрыть ключи' disabled='disabled' type='btn-outline-warning btn'/>
                        <Button class="col-12 col-sm-3 my-1" name="Экспорт" v-on:click="this.export_keys" icon_i='download' type='btn-outline-warning btn'/>
                    </div>
                </div>
                <div class='table-responsive'>
                <table v-if="this.data.visible" class="table table-borderless table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
				            <th>Ключ</th>
				            <th>№</th>
				            <th>Ключ</th>
				            <th>№</th>
				            <th>Ключ</th>
				            <th>№</th>
				            <th>Ключ</th>
                            <th>№</th>
				            <th>Ключ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in this.data.onekeys" :key="row.index">
                            <th>{{index * 5 + 1}}</th>
                            <td>{{row[index * 5]}}</td>
                            <th>{{index * 5 + 2}}</th>
                            <td>{{row[index * 5 + 1]}}</td>
                            <th>{{index * 5 + 3}}</th>
                            <td>{{row[index * 5 + 2]}}</td>
                            <th>{{index * 5 + 4}}</th>
                            <td>{{row[index * 5 + 3]}}</td>
                            <th>{{index * 5 + 5}}</th>
                            <td>{{row[index * 5 + 4]}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import SwitchSimple from '@/components/service/SwitchSimple';
import Button from '@/components/service/Button';

export default {
    components: {
        Button,
        SwitchSimple
    },
    data() {
        return {
            data: false,
            ready: false,
        }
    },
    methods: {
        updateState(state) {
            if (state.value === false) {
                state.value = '0';
            } else if (state.value === true) {
                state.value = '1';
            }
            this.data[state.id] = state.value;
            this.activate_onekey(state.value)
        },
        activate_onekey(val) {
            this.axios.post('ActivationDisposableKeys', {data: {active: val}})
        },
        get_onekey() {
            this.axios.post('GetDisposableKeys').then(res => {
                if (res.data.body.active == '1') {
                    res.data.body.active = true;
                }
                this.data = res.data.body});
        },
        gen_onekey() {
            this.$store.commit('MODAL', {
                action: true,
                type: 'pay_pass',
                content: {callback: () => {
                    this.axios.post('SetDisposableKeys').then(res => {this.data = res.data.body});
                }},
            });
        },
        export_keys() {
            window.location.assign("ExportDisposableKeys?data=" + JSON.stringify(this.data.onekeys));
        }
    },
    created() {
        this.$store.commit('TITLE', 'Одноразовые ключи');
        this.get_onekey();
    },
}
</script>