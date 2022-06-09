<template>
  <div ref='btntooltip' class='bs-tooltip' data-bs-toggle="tooltip" :title="this.content">

  </div>
</template>

<script>
  import { Tooltip } from 'bootstrap';
  export default {
    components: {
    },
    props: {
        content: {
            type: [String, Boolean],
            default: 'Some hint',
        },
        hover: {
            type: Boolean,
            default: true,
        },
        placement: {
            type: String,
            default: 'top',
        }
    },
    mounted() {
      this.bp();
    },
    methods: {
      bp() {
        new Tooltip(this.$refs.btntooltip)
      }
    }
  };
</script>

<style lang="scss">
.bs-tooltip {
  width: 26px;
  height: 26px;
  background-image: url('~@/assets/bi_question-circle.svg');
  background-repeat: no-repeat;
  background-position: center;
  background-size: 23px;
  cursor: pointer;
  margin: 0 5px;
}
</style>