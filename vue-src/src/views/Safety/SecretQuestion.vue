<template>
    <div class=''>
        <div class="row container-fluid g-3 p-0">
            <h5>В случае, если вы забудете пароль для доступа к кабинету, вы сможете восстановить его, ответив на секретный вопрос.</h5>
            <h5 class='my-1 pb-3'>В данном разделе вы можете сменить секретные вопрос/ответ.</h5>
        </div>
        <div v-if="this.get" class = 'content p-4'>
            <Select label="Секретный вопрос" :first="true" :dataValue.sync='this.data.question' id='question' :keywords.sync='this.keywords' @updateParentState="this.updateState"/>
            <Input type='text' :dataValue.sync='this.data.custom_question' :disabled='this.custom' label="Ваш вопрос:" id='custom_question' @updateParentState="this.updateState"/>
            <Input type='password' :dataValue.sync='this.data.answer' label="Ответ:" id='answer' @updateParentState="this.updateState"/>
        </div>
        <div class="row container-fluid g-3 align-items-center justify-content-center input">
            <div class="col-sm-2">
                <Button name='Сохранить' type='btn-warning btn-lg' v-on:click='this.setQuestion'/>
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/components/service/Input';
import Select from '@/components/service/Select';
import Button from '@/components/service/Button';

export default {
    components: {
        Input,
        Button,
        Select
    },
    data() {
        return {
            data: {
                question: false,
                custom_question: false,
                answer: false,
            },
            keywords: [],
            get: false,
            custom: '',
        }
    },
    methods: {
        updateState(state) {
            if (state.id == 'question') {
                if (state.value == 'custom') {
                    this.custom = false;
                } else {
                    this.data.custom_question = false;
                    this.custom = '';
                }

                this.data[state.id] = state.value;
            } else {
                this.data[state.id] = state.value; 
            }
            console.log(this.data)
        },
        getKeywords() {
            this.axios.post('getSecretQuestion').then(res => {this.keywords = res.data.body.keywords
                                                            if (res.data.body.advanced.secret_question_global != '0') {
                                                                this.data.question = res.data.body.advanced.secret_question_code
                                                            } else {
                                                                this.data.question = 'custom'
                                                                this.data.custom_question = res.data.body.advanced.secret_question_text
                                                                this.custom = false;
                                                            }
                                                            this.data.answer = res.data.body.advanced.secret_answer
                                                            this.get = true;
                                                        })
        },
        setQuestion() {
            this.axios.post('setSecretQuestion', {data: this.data});
        }
    },
    created() {
        this.$store.commit('TITLE', 'Секретный вопрос');
        this.getKeywords();
    },
}
</script>