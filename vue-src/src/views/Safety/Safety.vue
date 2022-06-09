<template>
  <div class='container-xl container-fluid pb-5'>
    <Title/>
    <router-view v-if="this.$store.state.userData"/>
  </div>
</template>

<script>
import Title from '@/components/service/Title';

export default {
  components: {
    Title,
  },
  created() {
    this.$store.commit('TITLE', 'Безопасность');
  },
}
</script>

<style lang="scss"> 

</style>