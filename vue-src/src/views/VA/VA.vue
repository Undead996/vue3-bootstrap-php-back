<template>
  <div class='container-xl container-fluid pb-5'>
    <Title/>
    <router-view/>
  </div>
</template>

<script>
import Title from '@/components/service/Title';

export default {
  components: {
    Title,
  },
  created() {
    this.$store.commit('TITLE', 'Список виртуальтных активов');
  },
}
</script>

<style lang="scss">

</style>