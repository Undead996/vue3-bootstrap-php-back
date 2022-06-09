<template>
    <div class='main-title container-xl p-0'>
        <h1>{{this.$store.state.title}}</h1>
    </div>
</template>

<script>
export default {
    
}
</script>

<style lang="scss">
.main-title {
    margin-top: 3rem;
    margin-bottom: 1rem;
    font-family: 'HelveticaNeue roman';
    h1 {
        font-size: 1.9rem;
    }
    font-weight: 100;
}
</style>