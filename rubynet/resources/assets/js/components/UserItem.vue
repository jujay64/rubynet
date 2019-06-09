<template>
<div>
  <div class="row add-people-section">
    <div class="small-12 medium-6 columns about-people">
      <div class="about-people-avatar">
        <img class="avatar-image" :src="user.picture">
      </div>
      <div class="about-user">
        <p class="user-name">
          {{user.lastName}} {{user.firstName}}
          <span class="yomikata">({{user.lastNameYomikata}} {{user.firstNameYomikata}})</span>
        </p>
        <p class="user-entrydate">
          <i class="fi-calendar" aria-hidden="true"></i>
          <span v-if="type == 1">
            Joined Rubygroupe on <strong>{{moment(user.entryDate).format('YYYY/MM/DD')}}</strong> 
          </span>
          <span v-else-if="type == 2">
            Birthday on <strong>{{moment(user.dateOfBirth).format('MM/DD')}}</strong>
          </span>
        </p>
        <p class="user-team">
          <i class="fi-torsos-all" aria-hidden="true"></i>
          <strong>{{user.departmentName}}</strong>'s team
        </p>
        <p class="user-phone">
          <i class="fi-telephone" aria-hidden="true"></i>
          <strong>{{user.internalPhoneNumber}}</strong>
        </p>
      </div>    
    </div>
    <div class="small-12 medium-6 columns add-friend">
      <div class="add-friend-action">
        <button @click="onClickViewProfile(user.identifier)" class="button primary small">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          See Profile
        </button>
      </div>
    </div>
  </div>
</div>
</template>
<script>
  import moment from 'moment';
  
  export default {
  props: [
  'title',
  'user',
  'type'
  ],
  methods: {
    moment,
    onClickViewProfile(identifier){
      this.$router.push({ name: 'user', params: {'id': identifier}});
    },
  },
  }
</script>