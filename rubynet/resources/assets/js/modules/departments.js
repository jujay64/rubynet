/*
|-------------------------------------------------------------------------------
| VUEX modules/users.js
|-------------------------------------------------------------------------------
| The Vuex data store for the departments
*/

import DepartmentAPI from '../api/department.js';

export const departments = {

  state: {
    departments: [],
    departmentsLoadStatus: 0,

    department: {},
    departmentLoadStatus: 0,
  },

  actions: {
    loadDepartments(context){
      context.commit('setDepartmentsLoadStatus', 1);

      DepartmentAPI.getDepartments()
        .then(function(response){
          context.commit('setDepartments', response.data);
          context.commit('setDepartmentsLoadStatus', 2);
        })
        .catch(function(){
          context.commit('setDepartments', []);
          context.commit('setDepartmentsLoadStatus', 3);
        });
    },

    loadDepartment({commit}, data){
      commit('setDepartmentLoadStatus', 1);

      DepartmentAPI.getDepartment(data.id)
        .then(function(response){
          commit('setDepartment', response.data);
          commit('setDepartmentLoadStatus', 2);
        })
        .catch(function(){
          commit('setDepartment', {});
          commit('setDepartmentLoadStatus', 3);
        });
    },
  },
  mutations: {
    setDepartmentsLoadStatus(state, status){
      state.departmentsLoadStatus = status;
    },

    setDepartments(state, departments){
      state.departments = departments;
    },

    setDepartmentLoadStatus(state, status){
      state.departmentLoadStatus = status;
    },

    setDepartment(state, department){
      state.user = user;
    },
  },  
  getters: {
    getDepartmentsLoadStatus(state){
      return state.departmentsLoadStatus;
    },

    getDepartments(state){
      return state.departments;
    },

    getDepartmentLoadStatus(state){
      return state.departmentLoadStatus;
    },

    getDepartment(state){
      return state.department;
    },

    getDepartmentById: (state) => (id) => {
      return state.departments.data.filter(function(d) {
        return d.identifier === id
      })[0];
    }
  }
}