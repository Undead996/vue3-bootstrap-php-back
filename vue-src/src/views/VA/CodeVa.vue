<template>
    <div class = 'content'>
      <table class="table">
        <thead>
          <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Ticker</th>
              <th scope="col">Categoty</th>
              <th scope="col">Mission</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="col">{{this.code}}</td>
            <td scope="col">{{this.curr.name_ru}}</td>
            <td scope="col">no</td>
            <td scope="col">{{this.curr.category}}</td>
            <td scope="col">{{this.curr.mission}}</td>
          </tr>
        </tbody>
        <thead>
          <tr>
              <th scope="col">Precision</th>
              <th scope="col">Responsible</th>
              <th scope="col">Cover_percent</th>
              <th scope="col">Logo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="col">{{this.curr.precision}}</td>
            <td scope="col">{{this.curr.responsible}}</td>
            <td scope="col">{{this.curr.cover_percent}}</td>
            <td scope="col"><img :src="this.curr.logo"></td>
          </tr>
        </tbody>
      </table>
    </div>
</template>

<script>
export default {
data() {
    return {
        code: this.$route.params.code ? this.$route.params.code : false,
        curr: false,
    }
},
methods: {
    codeExist() {
        this.axios.post('GetCustomCurrParams', {code: this.code}).then(res => {
            this.curr = res.data.body;
            this.$store.commit('TITLE', this.curr.name_ru);
        });
    }
},
created() {
    if (this.code) {
        this.codeExist();
    } else {
        this.$store.commit('TITLE', 'Вирутальные активы');
    }
},
}
</script>