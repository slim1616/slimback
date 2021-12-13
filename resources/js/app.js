import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import VueNotification from "@kugatsu/vuenotification";
import JsonExcel from "vue-json-excel";
import {mapGetters} from 'vuex';
import VueToastify from "vue-toastify";
import moment from 'moment'
Vue.use(VueToastify);
Vue.component("downloadExcel", JsonExcel);

Vue.use(VueNotification, {
  timer: 20
});
Vue.use(VueRouter)
Vue.use(Vuex);
import {store} from './store.js';
require('./bootstrap');
Vue.mixin({
    methods:{
        formatDate(val){
            if (val){
                return moment(val).format('DD/MM/YYYY');
            }else{
                return ""
            }
        }
    }
})
// window.Vue = require('vue');

import routes from './routes'
const router = new VueRouter({
    base : '/admin/',
    mode : 'history',
    routes,
    
})



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



import headerSite from './template/header'
import navigation from './template/navigation'
import loader from './template/loader'

const app = new Vue({
   
    components : {headerSite, navigation, loader},
    el: '#app',
    router,
    store,
    mounted(){
        this.$vToastify.setSettings({"position" : "top-right",
                                            "hideProgressbar" : true,
                                            // "defaultTitle" : false,
                                            "theme" : "light"
                                            });
        this.$store.dispatch('getUser')
       /*
        Echo.channel('rtl-channel')
        .listen('RtlEvent', function (e) {
            console.log('RtlEvent', e)
        })
        let el = 'porte-notifs-' + document.querySelector('#app').getAttribute('data-user')
        window.Echo.private(el)
                .listen('SendMessage', (e) => {
                    this.reciveMessage(e.message)
                })
        console.log(el);
        Echo.private( el)
            .listen('ErrorPorteEvent', e => {
                console.log(e)
                this.$vToastify.error({body:e.error.msg + ' ' + e.error.porte.titre + ' ' + e.error.porte.model + ' Ip : ' + e.error.porte.ip, title:"",defaultTitle:false, canTimeout:false} );
                // this.$toasted.error(e.error.msg + e.error.porte.titre + ' ' + e.error.porte.model + ' Ip : ' + e.error.porte.ip )
            })
            .listen('InfoPorteEvent', e => {
                

                this.$vToastify.info({body:e.info.msg + e.info.porte.titre + ' ' + e.info.porte.model + ' Ip : ' + e.info.porte.ip , title:"",defaultTitle:false});
                // this.$toasted.info(e.info.msg + e.info.porte.titre + ' ' + e.info.porte.model + ' Ip : ' + e.info.porte.ip )
                console.log(e)
            })
            .listen('SuccessPorteEvent', e => {
                console.log(e)
                this.$vToastify.success({body:e.success.msg + ' ' + e.success.porte.titre + ' ' + e.success.porte.model + ' Ip : ' + e.success.porte.ip, title:"",defaultTitle:false} );
                // this.$toasted.error(e.error.msg + e.error.porte.titre + ' ' + e.error.porte.model + ' Ip : ' + e.error.porte.ip )
            })
            */
           console.log('mounted App')
        

    },
    computed:{
        ...mapGetters({
            hideSideBar : 'getSideBarHide'
        })
    }
});
