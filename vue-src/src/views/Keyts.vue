<template>
  <div class='container-xl container-fluid pb-5'>
    <Title/>
    <div class = 'content p-4'>
        <div class='table-responsive'>
        <table class="table table-borderless table-striped neue-roman">
            <thead>
                <tr>
                    <th scope="col">Счет</th>
                    <th scope="col">Остаток</th>
                    <th scope="col">Статус</th>
                    <th v-if='this.aliases' scope="col">Дополнительная информация</th>
                    <th scope="col">Действия</th>
                    <th scope="col">с</th>
                </tr>
            </thead>
            <tbody class=''>
                <tr v-for="(row, index) in this.content" :key="index">
                    <td class="align-middle" scope="col">{{row.keyt}}<br/><span class='grey'>{{row.name}}</span></td>
                    <td class="align-middle" scope="col">{{row.balance}} <span class='grey'>{{row.curr}}</span></td>
                    <td class="align-middle" scope="col">
                        <span class='color-menu' v-if='row.in_status_code == "1" && row.out_status_code == "1"'>Активен</span>
                        <span class='acent' v-if='row.in_status_code != "1"' >Ввод {{row.in_status}}</span>
                        <span class='acent' v-if='row.out_status_code != "1"' > | Вывод {{row.out_status}}</span>
                    </td>
                    <td v-if='this.aliases' class="align-middle" scope="col">{{row.alias}}</td>
                    <td class="align-middle" scope="col">
                        <span class='href'>в</span>&nbsp;
                        <span class='href'>р</span>&nbsp;
                        <span class='href' v-if='row.card == ""'>д</span>
                    </td>
                    <td class="align-middle" scope="col">
                        <input type='checkbox' :name="`c_${index}`" :value='row.keyt' v-if="row.summ != '0.00'" disabled>
                        <input v-else type='checkbox' :name="`c_${index}`" :value='row.keyt'>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div class="d-flex container-fluid g-3 align-items-center justify-content-center">
        <Pagination class='col-sm-3' :data.sync='this.data' @updateContentState="this.updateContent"/>
    </div>
  </div>
</template>

<script>
import Title from '@/components/service/Title';
import Button from '@/components/service/Button';
import Pagination from '@/components/service/pagination/Pagination';

export default {
    components: {
        Button,
        Title,
        Pagination,
    },
    data() {
        return {
            content: {},
            data: {},
            aliases: false,
        }
    },
    created() {
        this.$store.commit('TITLE', 'Список счетов');
    },
    mounted() {
        this.getKeyts();
    },
    methods: {
        updateContent(arg) {
            arg.forEach(e => {
                if (e.alias != '') {
                    this.aliases = true;
                } else {
                    this.aliases = false;
                }
            });
            this.content = arg;
        },
        getKeyts() {
            this.axios.post('GetKeyts').then(res => this.data = res.data.body)
        }
    },
    
}
</script>

<style lang="scss">
.acent {
    color: $color-acent;
}
</style>