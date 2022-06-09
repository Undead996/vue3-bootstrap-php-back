<template>
    <div ref="modal" tabindex="0" class='vue-modal'>
        <div class='vue-modal-window mx-auto content p-4 col-xl-6 col-lg-8 col-10'>
            <Answer v-if="this.$store.state.modal.type == 'answer'" :close="this.close"/>
            <PayPass v-if="this.$store.state.modal.type == 'pay_pass'" :close="this.close"/>
            <Repeat v-if="this.$store.state.modal.type == 'repeat'" :close="this.close"/>
            <HistoryParams v-if="this.$store.state.modal.type == 'history'" :close="this.close"/>
        </div>
    </div>
</template>

<script>
import Answer from '@/components/service/modals/Answer';
import PayPass from '@/components/service/modals/PayPass';
import Repeat from '@/components/service/modals/Repeat';
import HistoryParams from '@/components/service/modals/HistoryParams';

export default {
    components: {
        Answer,
        PayPass,
        Repeat,
        HistoryParams
    },
    mounted() {
        this.$refs.modal.focus();
        document.querySelector('body').style.overflow = 'hidden';
        this.$store.commit('DARK_WRAPPER', true);
    },
    unmounted() {
        document.querySelector('body').style.overflow = 'auto';
    },
    methods: {
        close() {
            this.$store.commit('MODAL', {
                                        action: false,
                                        type: false,
                                        content: false,
                                        }
                                );
            this.$store.commit('DARK_WRAPPER', false);
        }
    },
}
</script>

<style lang="scss">
    .vue-modal {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        // background: rgba(0, 0, 0, 0.3); // Make sure this color has an opacity of less than 1
        z-index: 4000;
        padding-top: 20vh;
        outline: none;
        overflow: auto;
        h4 {
            font-size: 1.3rem;
        }
    }
</style>