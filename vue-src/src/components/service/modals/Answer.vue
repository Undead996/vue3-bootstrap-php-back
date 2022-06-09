<template>
    <div>
        <div class=''>
            <h4>{{this.status}}</h4>
        </div>
        <div class='row container-fluid mt-1 p-0'>
            {{this.content}}
        </div>
        <div class='d-flex mx-auto justify-content-center pt-3'>
            <Button name='ОК' type='btn-warning' v-on:click='this.close'/>
        </div>
    </div>
</template>

<script>
import Button from '@/components/service/Button';

export default {
    components: {
        Button
    },
    props: {
        close: [Function],
    },
    data () {
        return {
            status: this.$store.state.modal.content.result === '0' ? 'Успех' : 'Ошибка', 
            content: this.$store.state.modal.content.result_text,
        }
    },
    methods: {
        
    },
}
</script>
