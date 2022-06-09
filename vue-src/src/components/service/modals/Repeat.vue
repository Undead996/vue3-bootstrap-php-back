<template>
    <div>
        <div class=''>
            <h4>{{this.content.result_text}}</h4>
        </div>
        <div v-if='this.content.result == "857"' class='row container-fluid mt-1 p-0 g-3'>
            <h5 class='p-0'>{{this.content.advanced.notify_text}}</h5>
            <Input label="Ввод: " id='sms_confirm_value' @updateParentState="this.updateState" hint=''/>
        </div>
        <div v-if='this.content.result == "856"' class='row container-fluid mt-1 p-0 g-3'>
            <h5 class='p-0'>{{this.content.advanced.confirm_text}}</h5>
            <Input label="Ввод: " id='sms_confirm_value' @updateParentState="this.updateState" hint=''/>
        </div>
        <div class='d-flex mx-auto justify-content-center pt-3'>
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
            content: this.$store.state.modal.content,
            sms_confirm_value: false,
            callbacks: {
                login:(res) => {
                    this.$store.commit('USER_DATA', res.data.body);
                }
            } 
        }
    },
    methods: {
        updateState(state) {
            this.sms_confirm_value = state.value;
        },
        getCallback(res) {
            if (this.content.repeat_url == 'login') {
                this.callbacks.login(res)
            } else {
                return;
            }
        },
        submit() {
            this.$store.commit('MODAL', {
                        action: false,
                        type: false,
                        content: false
                    })
            let data = this.content.repeat;
            if ( this.content.result == "857" ) {
                data.magicword = this.sms_confirm_value;
            }
            if ( this.content.result == "856" ) {
                data.onekey = this.sms_confirm_value;
            }
            this.axios.post(this.content.repeat_url, data).then(res => 
                {this.getCallback(res)}
            );
        }
    },
}
</script>