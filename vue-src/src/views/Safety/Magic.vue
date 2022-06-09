<template>
    <div class=''>
        <div>
            <div class="row container-fluid g-3 p-0">
                <h5>Волшебное слово - это дополнительная настройка безопасности.</h5>
                <h5 class='my-1'>Если волшебное слово включено, то каждый раз при авторизации система будет просить вас ввести какие-то символы (по их порядковому номеру) из волшебного слова.</h5>
            </div>
            <div class = 'content my-2 p-4'>
                <Input type='text' :dataValue='this.data.magic_word' :first='true' label="Волшебное слово:" :require="true" id='magic_word' @updateParentState="this.updateState"/>
            </div>
            <div class="row container-fluid mt-1 g-3 p-0">
                <h3>Спрашивать волшебное слово:</h3>
            </div>
        </div>
        <div class = 'content p-4'>
            <Switch label="При входе в кабинет:" :first='true' :dataValue='this.data.antifishing_on'  id='on_enter' @updateParentState="this.updateState"/>
            <Switch label="При оплате через мерчант:" id='on_merchant'  @updateParentState="this.updateState"/>
            <Switch label="При использовании карты:"  id='on_card' @updateParentState="this.updateState"/>
        </div>
        <div class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click="this.set_magic"/>
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
                magic_word: '',
                on_card: false,
                on_enter: false,
                on_merchant: false,
            },
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
            console.log(this.data)
        },
        set_magic() {
            this.axios.post('SetMagic', {data: this.data});
        },
        get_magic() {
            this.axios.post('GetMagic').then(res => {this.data = res.data.body});
        }
    },
    created() {
        this.$store.commit('TITLE', 'Волшебное слово');
        this.get_magic();
    },
}
</script>