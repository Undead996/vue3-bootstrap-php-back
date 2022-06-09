<template>
  <div>
    <h1>ForTests</h1>
    <button v-on:click="this.get_custom_curr">GETLISTCUSTOMCURR</button>
    <div>
      
    </div>
  </div>
</template>

<script>
// @ is an alias to /src

export default {

    methods: {
        get_custom_curr() {
            this.axios.post('GetCustomCurr');
        } 
    }
}
</script>
<style lang="scss">
  .class {
    display: flex;
    flex-direction: column;
  }
</style>