
const state = {
    loading : false,
    sideBarHide : false

}

const getters = {
    getLoading(state){
        return state.loading;
    },
    getSideBarHide(state){
        return state.sideBarHide
    }
}


const mutations = {
    SET_LOADER(state, bool){
        state.loading = bool
    },
    SET_SideBarHide(state, val){
        state.sideBarHide = val
    }
}


const actions = {
    setLoader(context, bool){
        context.commit('SET_LOADER', bool)
    },
    setSideBarHide(context, bool){
        context.commit('SET_SideBarHide', bool)
    }
}

export default {state, getters, mutations, actions}
