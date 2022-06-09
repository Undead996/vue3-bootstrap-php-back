<template>
  <div class='container-xl container-fluid px-4 px-md-3 pb-5'>
    <Title/>
    <div class='user'>
      <p> Hello : {{this.$store.state.userData.user_name}}</p>
      <p> ID : {{this.$store.state.userData.id}}</p>
    </div>
  </div>
</template>

<script>
import Title from '@/components/service/Title';

export default {
  components: {
    Title
  },
  created() {
    this.$store.commit('TITLE', 'HomePage');
  },
}
</script>
<style lang="scss">
</style>