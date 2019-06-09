<style>

</style>
<template>

<span v-if="userLoadStatus == 1">Loading user...</span>

<ul v-else-if="userLoadStatus == 2" class="menu dropdown" data-dropdown-menu>
  <li>       
      <a href="#">
        <img class="avatar" :src="user.data.picture"/>
        <span>{{user.data.firstName}}</span>          
      </a>
      <ul class="menu">
        <li>
          <a @click="onClickViewProfile(user.data.identifier);">
            My profile
          </a> 
        </li>
        <li>
          <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
            Logout
          </a> 
        </li>
      </ul>  
  </li>
</ul>

</template>
<script>     
    export default { 
      created(){
      this.$store.dispatch('loadAuthenticatedUser');
      },    
      /*
        Defines the computed properties on the component.
      */
      computed:{
          /*
          Retrieves the User Load Status from Vuex
          */
          userLoadStatus(){
            return this.$store.getters.getAuthenticatedUserLoadStatus;
          },

          /*
          Retrieves the User from Vuex
          */
          user(){
            return this.$store.getters.getAuthenticatedUser;
          }
      },
      updated: function(){
        $(this.$el).foundation();  
      },
      methods: {
        onClickViewProfile(identifier){
          this.$router.push({ name: 'user', params: {'id': identifier}});
        },
      },
    }  
</script>    