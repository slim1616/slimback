
const state = {
    loading : false
}

const getters = {
    getLoading(state){
        return state.loading;
    }
}


const mutations = {
    SET_LOADER(state, bool){
        state.loading = bool
    }
}


const actions = {
    setLoader(context, bool){
        context.commit('SET_LOADER', bool)
    }
}

export default {state, getters, mutations, actions}
