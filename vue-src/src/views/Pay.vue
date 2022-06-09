<template>
    <div class='d-flex container-xl container-fluid'>
        <div class='col-3 leftm'>

        </div>
        <div class='col-9 p-4 rightc'>
            <div class="main-title container-fluid p-0">
            <h1>Шаблоны</h1>
        </div>
        </div>
    </div>
</template>

<script>

export default {

    data() {
        return {
            operators_list: false,
        }
    },
    mounted() {
        this.getList();
    },
    methods: {
        getList() {
            this.axios.post('getOperatorsListMenu')
        }
    },
}
</script>

<style lang="scss">
.leftm {
    min-height: 100vh;
    background-color: $color-left-menu;
    box-shadow: inset -2px 0px 8px 1px #EFEFEF;
}

.rightc {
    padding-top: 0 !important;
    padding-right: 0 !important;
}
</style>