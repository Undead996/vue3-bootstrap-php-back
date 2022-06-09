<template>
    <div class=''>
        <div class="row container-fluid g-3 p-0">
            <h5>Настройка антифишинга является дополнительным механизмом защиты при работе с кабинетом.</h5>
            <h5 class='my-1'>Заданная вами приветственная фраза будет отображаться в верхней части любой страницы кабинета.</h5>
            <h5 class='pb-3 my-1'>Правильная фраза покажет вам, что вы находитесь на правильном сайте, неверная фраза явится сигналом: не осуществляя операций, необходимо срочно связаться со службой безопасности нашей системы.</h5>
        </div>
        <div class = 'content p-4'>
            <Switch label="Включить антифишинг:" :dataValue='this.data.antifishing_on' :first='true' id='antifishing_on' @updateParentState="this.updateState"/>
            <Input type='text' :dataValue='this.data.string' label="Строка антифишинга:" :disabled='!this.data.antifishing_on' :require="true" id='string' @updateParentState="this.updateState"/>
        </div>
        <div class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.set_antifishing"/>
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Switch from '@/components/service/Switch';
import Button from '@/components/service/Button';

export default {
    components: {
        Input,
        Button,
        Switch
    },
    data() {
        return {
            data: {
                antifishing_on: this.$store.state.userData.antiphishing ? true : false,
                string: this.$store.state.userData.antiphishing,
            },
            ready: false,
        }
    },
    methods: {
        updateState(state) {
            this.data[state.id] = state.value;
        },
        set_antifishing() {
            if (this.data.antifishing_on) {
                this.data.antifishing_on = '1';
            } else {
                this.data.antifishing_on = '0';
            }
            this.axios.post('SetAntifishing', {data: this.data}).then(res => { 
                                if (res.data.body.result == '0') {
                                    this.$store.dispatch('logout', this.$router);
                                }
                            });
        }
    },
    created() {
        this.$store.commit('TITLE', 'Антифишинг');
    },
}
</script>