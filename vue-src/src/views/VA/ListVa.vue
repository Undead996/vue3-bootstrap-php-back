<template>
    <div>
        <div class = 'content p-4 table-responsive'>
            <table class="table table-borderless table-striped neue-roman">
                <thead>
                    <tr>
                        <th scope="col">№  </th>
                        <th scope="col">Логотип</th>
                        <th scope="col">Название</th>
                        <th scope="col">TICKER</th>
                        <th scope="col">Категория</th>
                        <th scope="col">Цель</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody v-if='this.content'>
                    <tr v-for="curr in this.content" :key="curr.curr_code">
                        <th class="align-middle" scope="col">{{curr.curr_code}}</th>
                        <td class="align-middle curr_logo" scope="col"><img :src="curr.logo"></td>
                        <td class="align-middle" scope="col">{{curr.name}}</td>
                        <td class="align-middle" scope="col">{{curr.ticker}}</td>
                        <td class="align-middle" scope="col">{{curr.category}}</td>
                        <td class="align-middle" scope="col">{{curr.mission}}</td>
                        <td class="align-middle" scope="col">
                            <router-link class='action' :to="{name:'CodeVA', params: {code: curr.curr_code}}"><i class="bi bi-eye"></i></router-link>
                            <span class='action'><i class="bi bi-pencil"></i></span>
                            <span class='action' v-on:click="this.delete_custom_curr(curr.curr_code)"><i class="bi bi-trash3"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex container-fluid g-3 align-items-center justify-content-center">
            <Pagination class='col-sm-3' :data.sync='this.currs' @updateContentState="this.updateContent"/>
        </div>
    </div>
</template>

<script>
import Pagination from '@/components/service/pagination/Pagination';

export default {
    components: {
        Pagination
    },
    data() {
        return {
            currs: {},
            content: false,
        }
    },
    methods: {
        get_custom_curr() {
            this.axios.post('GetCustomCurr').then(res => {this.currs = res.data.body});
        },
        delete_custom_curr(curr) {
            this.axios.post('DeleteCustomCurr', {code: curr}).then(res => {this.get_custom_curr()});
        },
        updateContent(arg) {
            this.content = arg;
        }, 
    },
    created() {
        this.$store.commit('TITLE', 'Список виртуальтных активов');
        this.get_custom_curr();
    },
}
</script>

<style scoped>
.action {
    cursor: pointer;
    margin: 5px;
}
.curr_logo img {
    max-width: 120px;
}
</style>