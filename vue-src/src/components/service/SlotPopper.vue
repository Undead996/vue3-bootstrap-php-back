<template>
  <div ref='btntooltip' class='s-tooltip' :data-bs-placement="this.placement" data-bs-toggle="tooltip" :data-bs-original-title="this.content">
      <slot></slot>
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
    .s-tooltip {
        cursor: pointer;
    }
</style>