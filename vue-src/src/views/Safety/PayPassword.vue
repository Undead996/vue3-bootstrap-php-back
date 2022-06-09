<template>
    <div class=''>
        <div class = 'content p-4' v-if="!this.$store.state.userData.user_info.need_paypass">
            <Input type='password' label="Старый пароль:" :first='true' :require="true" id='old_password' @updateParentState="this.updateState" />
            <Input type='password' label="Новый пароль:" :require="true" id='new_password' @updateParentState="this.updateState" />
            <Input type='password' label="Подтверждение пароля:" :require="true" id='check' @updateParentState="this.updateState" />
        </div>
        <div class = 'content' v-else>
            <Input type='password' label="Новый пароль:" :require="true" id='new_password' @updateParentState="this.updateState" />
            <Input type='password' label="Подтверждение пароля:" :require="true" id='check' @updateParentState="this.updateState" />
        </div>
        <div v-if="!this.$store.state.userData.user_info.need_paypass" class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.changePass"/>
            </div>
        </div>
        <div v-else class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.createPass"/>
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Button from '@/components/service/Button';
import lib from '@/includes/lib.js';

export default {
    components: {
        Input,
        Button
    },
    data() {
        return {
            title: this.$store.state.userData.user_info.need_paypass ? 'Создание платежного пароля' : 'Изменение платежного пароля',
            data: {
                new_password: false,
                check: false,
                old_password: false,
            },
            ready: false,
        }
    },
    methods: {
        updateState(state) {
            this.data[state.id] = state.value;
            if (this.data.check && this.data.old_password && this.data.new_password) {
                this.ready = true;
            } else {
                this.ready = false;
            }
        },
        changePass() {
            if (this.data.new_password !== this.data.check) {
                this.$store.dispatch('modalAnswer', {code: 1, text: '"Новый пароль" и "Подтверждение пароля" не совпадают.'});
                return;
            }
            if (lib.checkRegExp(this.data.new_password, '[а-яА-Яее]+')) {
                this.$store.dispatch('modalAnswer', {code: 1, text: 'Пароль не должен содержать кириллицу'});
                return;
            }
            this.axios.post('ChangePayPass', {data: {new_password: this.data.new_password,
                                                   old_password: this.data.old_password}}
                            );
        },
        createPass() {
            if (this.data.new_password !== this.data.check) {
                this.$store.dispatch('modalAnswer', {code: 1, text: '"Новый пароль" и "Подтверждение пароля" не совпадают.'});
                return;
            }
            if (lib.checkRegExp(this.data.new_password, '[а-яА-Яее]+')) {
                this.$store.dispatch('modalAnswer', {code: 1, text: 'Пароль не должен содержать кириллицу'});
                return;
            }
            this.axios.post('CreatePayPass', {data: {new_password: this.data.new_password}}
                            );
        }
    },
    created() {
        this.$store.commit('TITLE', this.title);
    },
}
</script>