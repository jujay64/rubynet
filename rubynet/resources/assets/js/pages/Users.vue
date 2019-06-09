<style>
.per-page{
  margin-top : 5px;
  padding-left: 30px;
}
</style>

<template>
<div>
<div class="sort-header">
  <!--RESULTS-->
    <span>{{ this.pagination.totalItems}} results</span>
    <!--SORT BAR -->
    <ul class="menu align-center">
      <li><a class="sort-link" @click="onClickSort('entryDate')">Entry Date 
        <span v-if="pagination.sortBy == 'entryDate' && pagination.descending == true"><i class="fi-arrow-down"></i></span>
        <span v-else-if="pagination.sortBy == 'entryDate' && pagination.descending == false"><i class="fi-arrow-up"></i></span>
        </a>
      </li>
      <li><a class="sort-link" @click="onClickSort('lastNameYomikata')">Last Name 
        <span v-if="pagination.sortBy == 'lastNameYomikata' && pagination.descending == true"><i class="fi-arrow-down"></i></span>
        <span v-else-if="pagination.sortBy == 'lastNameYomikata' && pagination.descending == false"><i class="fi-arrow-up"></i></span>
        </a>
      </li>
      <li><a class="sort-link" @click="onClickSort('firstNameYomikata')">First Name 
        <span v-if="pagination.sortBy == 'firstNameYomikata' && pagination.descending == true"><i class="fi-arrow-down"></i></span>
        <span v-else-if="pagination.sortBy == 'firstNameYomikata' && pagination.descending == false"><i class="fi-arrow-up"></i></span>
        </a>
      </li>
      <ul class="dropdown menu" data-dropdown-menu>
        <li>
          <a>{{ currentDepartmentFilter ? currentDepartmentFilter.name : 'All Departments'}}</a>
          <ul class="menu">
          <li v-if="departmentFilter">
            <a @click="onClickFilterDepartment('')">All Departments</a>
          </li>
          <li v-for="department in departments.data" v-if="department.identifier != departmentFilter">
            <a @click="onClickFilterDepartment(department.identifier)">{{department.name}}</a>
          </li>
          </ul>
        </li>
      </ul>
      <!-- ITEMS PER PAGE-->
      <span class="per-page">Users per page : </span>
      <ul class="dropdown menu" data-dropdown-menu>
        <li>
          <a>{{pagination.usersPerPage}}</a>
          <ul class="menu">
          <li v-for="num in pagination.usersPerPageItems" v-if="num != pagination.usersPerPage">
            <a @click="onClickChangeItemsPerPage(num)">{{num}}</a>
          </li>
          </ul>
        </li>
      </ul>
    </li>
    </ul>
    </ul>
    </div>
    
    <div v-if ="usersLoadStatus == 1" class="lds-facebook"><div></div><div></div><div></div></div>
    <div v-else-if ="usersLoadStatus == 2" class="people-you-might-know">
      <div class="people-header">
      <h6 class="header-title">
        Ruby's People
      </h6>
    </div>
    <user v-for="user in users.data" :key="user.identifier" :user="user" type="1"></user>
      <pagination v-if="this.pagination.totalPages > 1" 
      :total-pages="this.pagination.totalPages"
      :total="this.pagination.totalItems"
      :current-page="this.pagination.page"
      :maxVisibleButtons="4"
      @pagechanged="onPageChange">
      </pagination>
  </div>
</div>
</template>

<script>
  import user from '../components/UserItem.vue';
  import pagination from '../components/global/Pagination.vue';

  export default {
    components: {
      user,
      pagination
    },
  	created(){
      this.$store.dispatch('loadUsers');
      this.$store.dispatch('loadDepartments');
  	},
  	 /*
      Defines the computed properties on the component.
    */
    computed: {
      /*
        Gets the users load status
      */
      usersLoadStatus(){
        return this.$store.getters.getUsersLoadStatus;
      },

      /*
        Gets the users
      */
      users(){
        return this.$store.getters.getUsers;
      },

      /*
        Gets the pagination
      */
      pagination(){
        return this.$store.getters.getPagination;
      },

      
      /*
      Gets the selected department filter id
      */
      departmentFilter(){
        return this.$store.getters.getFilterDepartment;
      },

      /*
      Gets the selected department filter
      */
      currentDepartmentFilter(){
        console.log('departmentFilter value : ' + this.departmentFilter);
        if(this.departmentFilter)
          return this.$store.getters.getDepartmentById(this.departmentFilter);
        else
          return null;
      },

      /*
        Gets the departments
      */
      departments(){
        return this.$store.getters.getDepartments;
      },
  	},
    updated: function(){
        $(this.$el).foundation();
    },
    methods: {
    onPageChange(page){
      this.$store.commit('setPage', page);
      this.$store.dispatch('loadUsers');
    },
    onClickSort(sort){
      if (sort == this.pagination.sortBy)
        this.$store.commit('setDescending', !this.pagination.descending);
      else
        this.$store.commit('setDescending', false);
      this.$store.commit('setSort', sort);
      this.$store.commit('setPage', 1);
      this.$store.dispatch('loadUsers');
    },
    onClickFilterDepartment(department){
       this.$store.commit('setFilterDepartment', department);
       this.$store.commit('setPage', 1);
       this.$store.dispatch('loadUsers');
    },
    onClickChangeItemsPerPage(num){
       this.$store.commit('setUsersPerPage', num);
       this.$store.commit('setPage', 1);
       this.$store.dispatch('loadUsers');
    }
  },
  }
</script>