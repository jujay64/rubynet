/*
|-------------------------------------------------------------------------------
| VUEX modules/users.js
|-------------------------------------------------------------------------------
| The Vuex data store for the users
*/

import UserAPI from '../api/user.js';

export const users = {

  state: {
    pagination: {
      descending: true,
      page: 1,
      usersPerPage: 8,
      sortBy: 'entryDate',
      totalItems: 0,
      totalPages: 0,
      usersPerPageItems: [4, 8, 12, 16]
    },
    filter: {
      department: '',
    },
    users: [],
    usersLoadStatus: 0,

    user: {},
    userLoadStatus: 0,

    userEdit: {},

    newUsers: [],
    newUsersLoadStatus: 0,

    birthdayUsers: [],
    birthdayUsersLoadStatus: 0,

    authenticatedUser: {},
    authenticatedUserLoadStatus: 0,

    userPictureLoadStatus: 0,
  },

  actions: {
    loadUsers(context){
      context.commit('setUsersLoadStatus', 1);

      const { sortBy, descending, page, usersPerPage } = context.state.pagination;
      const department = context.state.filter.department;

      UserAPI.getUsers(sortBy, descending, page, usersPerPage, department)
        .then(function(response){
          context.commit('setUsers', response.data);
          context.commit('setPage', response.data.meta.pagination.current_page);
          context.commit('setTotalItems', response.data.meta.pagination.total);
          context.commit('setTotalPages', response.data.meta.pagination.total_pages);
          context.commit('setUsersLoadStatus', 2);
        })
        .catch(function(){
          context.commit('setUsers', []);
          context.commit('setUsersLoadStatus', 3);
        });
    },

    loadUser({commit}, id){
      commit('setUserLoadStatus', 1);

      UserAPI.getUser(id)
        .then(function(response){
          commit('setUser', response.data);
          commit('setUserLoadStatus', 2);
        })
        .catch(function(){
          commit('setUser', {});
          commit('setUserLoadStatus', 3);
        });
    },

    loadAuthenticatedUser({commit}){
      commit('setAuthenticatedUserLoadStatus', 1);

      UserAPI.getAuthenticatedUser()
        .then(function(response){
          commit('setAuthenticatedUser', response.data);
          commit('setAuthenticatedUserLoadStatus', 2);
        })
        .catch(function(){
          commit('setAuthenticatedUser', {});
          commit('setAuthenticatedUserLoadStatus', 3);
        });
    },

    loadNewUsers({commit}){
      commit('setNewUsersLoadStatus', 1);

      UserAPI.getNewUsers()
        .then(function(response){
          commit('setNewUsers', response.data);
          commit('setNewUsersLoadStatus', 2);
        })
        .catch(function(){
          commit('setNewUsers', []);
          commit('setNewUsersLoadStatus', 3);
        });
    },

    loadBirthdayUsers({commit}){
      commit('setBirthdayUsersLoadStatus', 1);

      UserAPI.getBirthdayUsers()
        .then(function(response){
          commit('setBirthdayUsers', response.data);
          commit('setBirthdayUsersLoadStatus', 2);
        })
        .catch(function(){
          commit('setBirthdayUsers', []);
          commit('setBirthdayUsersLoadStatus', 3);
        });
    },

    updateUserPicture({commit}, payload){
    UserAPI.updateUserPicture(payload.picture, payload.userID)
      .then(function(response){
         commit('setAuthenticatedUser', response.data);
         commit('setUser', response.data);
        })
      .catch(error => console.log(error));
    },

    updateUser({commit}, user){
    UserAPI.updateUser(user)
      .then(function(response){
         commit('setAuthenticatedUser', response.data);
         commit('setUser', response.data);
        })
      .catch(error => console.log(error));
    }
  },

  mutations: {
    setUsersLoadStatus(state, status){
      state.usersLoadStatus = status;
    },

    setUsers(state, users){
      state.users = users;
    },

    setUserLoadStatus(state, status){
      state.userLoadStatus = status;
    },

    setUser(state, user){
      state.user = user;
    },

    setUserEdit(state, user){
      state.userEdit = user;
    },

    setAuthenticatedUserLoadStatus(state, status){
      state.authenticatedUserLoadStatus = status;
    },

    setAuthenticatedUser(state, user){
      state.authenticatedUser = user;
    }, 

    setNewUsers(state, users){
      state.newUsers = users;
    },

    setNewUsersLoadStatus(state, status){
      state.newUsersLoadStatus = status;
    },

    setBirthdayUsers(state, users){
      state.birthdayUsers = users;
    },

    setBirthdayUsersLoadStatus(state, status){
      state.birthdayUsersLoadStatus = status;
    },

    setPage(state, page){
      state.pagination.page = page;
    },

    setSort(state, sort){
      state.pagination.sortBy = sort;
    },

    setDescending(state, descending){
      state.pagination.descending = descending;
    },

    setTotalItems(state, totalItems){
      state.pagination.totalItems = totalItems;
    },

    setTotalPages(state, totalPages){
      state.pagination.totalPages = totalPages;
    },

    setFilterDepartment(state, department){
      state.filter.department = department;
    },

    setUsersPerPage(state, num){
      state.pagination.usersPerPage = num;
    },

    setAuthenticatedUser(state, user){
      state.authenticatedUser = user;
    }
  },

  getters: {
    getUsersLoadStatus(state){
      return state.usersLoadStatus;
    },

    getUsers(state){
      return state.users;
    },

    getUserLoadStatus(state){
      return state.userLoadStatus;
    },

    getUser(state){
      return state.user;
    },

    getUserEdit(state){
      return state.userEdit;
    },

    getAuthenticatedUser(state){
      return state.authenticatedUser;
    },

    getAuthenticatedUserLoadStatus(state){
      return state.authenticatedUserLoadStatus;
    },

    getNewUsers(state){
      return state.newUsers;
    },

    getNewUsersLoadStatus(state){
      return state.newUsersLoadStatus;
    },

    getBirthdayUsers(state){
      return state.birthdayUsers;
    },

    getBirthdayUsersLoadStatus(state){
      return state.birthdayUsersLoadStatus;
    },

    getPagination(state){
      return state.pagination;
    },

    getFilterDepartment(state){
      return state.filter.department;
    },
  }
}