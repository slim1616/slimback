import Vue from 'vue'
import singleFront from './components/Enquetes/singleFront';
import afterresponse from './components/Enquetes/afterresponse';
const app = new Vue({
    el: '#app',
    components: {
        singleFront,
        afterresponse
    },
    mounted(){
        console.log('mounted')
    }
}); 