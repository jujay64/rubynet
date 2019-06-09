<style>

</style>

<template>
  
<div>
  <div v-if ="newUsersLoadStatus == 1" class="lds-facebook"><div></div><div></div><div></div></div>
  <div v-else-if ="newUsersLoadStatus == 2" class="people-you-might-know">
    <div class="add-people-header">
      <h6 class="header-title">
        Say 'Hi!' to Ruby's New Comers
      </h6>
    </div>  
    <user v-for="user in newUsers.data" :key="user.identifier" :user="user" type="1"></user>
    <div class="view-more-people">
      <p class="view-more-text">
        <router-link :to="{ name: 'users' }">View More...</router-link>
      </p>
    </div>
  </div>

  <div v-if ="birthdayUsersLoadStatus == 1" class="lds-facebook"><div></div><div></div><div></div></div>
  <div v-else-if ="birthdayUsersLoadStatus == 2" class="people-you-might-know">
    <div class="add-people-header">
      <h6 class="header-title">
        This month's birthdays
      </h6>
    </div>  
    <user v-for="user in birthdayUsers.data" :key="user.identifier" :user="user" type="2"></user>
  </div>
</div>
</template>

<script>
  import user from '../components/UserItem.vue';

  export default {
    components: {
      user
    },
  	created(){
      this.$store.commit('setPage', 1);
      this.$store.dispatch('loadNewUsers');
      this.$store.dispatch('loadBirthdayUsers');
  	},
  	 /*
      Defines the computed properties on the component.
    */
    computed: {
      /*
        Gets the birthday users load status
      */
      birthdayUsersLoadStatus(){
        return this.$store.getters.getBirthdayUsersLoadStatus;
      },

      /*
        Gets the birthday users
      */
      birthdayUsers(){
        return this.$store.getters.getBirthdayUsers;
      },
      /*
        Gets the new users load status
      */
      newUsersLoadStatus(){
        return this.$store.getters.getNewUsersLoadStatus;
      },

      /*
        Gets the new users
      */
      newUsers(){
        return this.$store.getters.getNewUsers;
      }
  	}
  }
</script>
