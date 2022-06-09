<template>
    <div>
        <div class=''>
            <h4>{{this.status}}</h4>
        </div>
        <div class=''>
            <Input type='password' label="Пароль: " id='pay_pass' @updateParentState="this.updateState" hint=''/>
        </div>
        <div class='d-flex mx-auto justify-content-center pt-3'>
            <Button name='Отмена' class='mr-1' type='btn-outline-warning' v-on:click='this.close'/>
            <Button name='Продолжить' type='btn-warning' v-on:click='this.submit'/>
        </div>
    </div>
</template>

<script>
import Button from '@/components/service/Button';
import Input from '@/components/service/Input';

export default {
    components: {
        Button,
        Input
    },
    props: {
        close: [Function],
    },
    data () {
        return {
            status: 'Введите платежный пароль',
            pass: false, 
        }
    },
    methods: {
        updateState(state) {
            this.pass = state;
        },
        submit() {
            this.$store.commit('PAY_PASS', this.pass.value);
            let callback = this.$store.state.modal.content.callback;
            this.$store.commit('MODAL', {
                        action: false,
                        type: false,
                        content: false
                    })
            this.$store.commit('DARK_WRAPPER', false);
            callback();
        }
    },
}
</script>