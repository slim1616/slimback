<template>
    <div class="general-loader" v-if="loading">
        <div class="loader loader-lg"></div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed:{
        ...mapGetters({
            loading:'getLoading'
        })
    }
}
</script>


<style scoped>
    .general-loader{
        position: fixed;
        top : 0;
        bottom: 0;
        left : 0;
        right: 0;
        z-index: 99999;
        background: #00000061;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
