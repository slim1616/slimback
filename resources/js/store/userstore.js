
const state = {
    user :{}
}

const getters = {
    getUser(state){
        return state.user;
    }
}


const mutations = {
    SET_USER(state, user){
        state.user = user
    }
}


const actions = {
    setUser(context, user){
        context.commit('SET_USER', user)
    },
    getUser(context){
        let res = fetch(window.location.origin + '/api/getuser',{
            headers : {
                'Content-type' : 'Application/json',
                // 'Accept':'application/json',
                'X-Requested-With' : 'XMLHttpRequest',
                'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then((response) => {
            if (response.ok) {
              return response.json();
            }else{
                window.location.replace(window.location.href);
                // throw response;
            }
          })
        .then(data => {
            context.commit('SET_USER', data.user)
        })
    }
}

export default {state, getters, mutations, actions}
