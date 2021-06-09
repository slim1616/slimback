import Vue from 'vue';
import Vuex from 'vuex';



import userstore from './store/userstore.js'
import generalStore from './store/generalStore.js'


Vue.use(Vuex);





export const store = new Vuex.Store({
    namespaces : true,
    modules : {userstore, generalStore }

});
