<template>
    <div class=''>
        <div class = 'content p-4'>
            <Input type='password' label="Старый пароль:" :first='true' :require="true" id='old_password' @updateParentState="this.updateState" />
            <Input type='password' label="Новый пароль:" :require="true" id='new_password' @updateParentState="this.updateState" />
            <Input type='password' label="Подтверждение пароля:" :require="true" id='check' @updateParentState="this.updateState" />
        </div>
        <div class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.changePass" :disabled='!this.ready'/>
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Button from '@/components/service/Button';

export default {
    components: {
        Input,
        Button
    },
    data() {
        return {
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
                this.$store.commit('MODAL_ACTION', true);
                this.$store.commit('MODAL_TYPE', 'answer');
                this.$store.commit('MODAL_CONTENT', {result: 1,
                                               result_text: '"Новый пароль" и "Подтверждение пароля" не совпадают.'});
                return;
            }
            this.axios.post('ChangePass', {data: {new_password: this.data.new_password,
                                                   old_password: this.data.old_password}}
                            );
        }
    },
    created() {
        this.$store.commit('TITLE', 'Изменение пароля');
    },
}
</script>