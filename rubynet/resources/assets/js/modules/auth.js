/*
|-------------------------------------------------------------------------------
| VUEX modules/users.js
|-------------------------------------------------------------------------------
| The Vuex data store for the users
*/

import AuthAPI from '../api/auth.js';

export const auth = {
   state: {
    logoutUserLoadStatus: 0
  },

  actions: {
      logoutUser({commit}){
      commit('setLogoutUserLoadStatus', 1);
      AuthAPI.postLogout()
      	.then(function(response){
      	  delete axios.defaults.headers.common['X-CSRF-TOKEN']
          commit('setLogoutUserLoadStatus', 2);
        })
        .catch(function(){
          commit('setLogoutUserLoadStatus', 3);
        });
    }
  },

  mutations: {
    setLogoutUserLoadStatus(state, status){
      state.logoutUserLoadStatus = status;
    },
  }
}