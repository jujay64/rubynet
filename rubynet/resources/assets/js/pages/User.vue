<template>
  <div v-if="userLoadStatus == 1" class="lds-facebook"><div></div><div></div><div></div></div>
  <div v-else-if="userLoadStatus == 2" class="card-profile-stats">
  <div class="card-profile-stats-intro">
    <imageinput v-if="user.data.identifier == authenticatedUser.data.identifier" v-model="avatar">
        <div slot="activator">
        <v-hover>
        <v-avatar size="200px" v-ripple slot-scope="{ hover }" class="mb-3">
          <v-img v-if="!avatar" :src="user.data.picture" alt="profile-image">
            <v-expand-transition>
            <div
              v-if="hover"
              class="d-flex transition-fast-in-fast-out black darken-2 v-avatar--reveal display-1 white--text"
              style="height: 100%;padding-top:15px;"
            >
              <div>
                Change pic<br />
                <i class="fi-camera"></i>
              </div>
            </div>
          </v-expand-transition>
          </v-img> 
          <v-img v-else :src="avatar.imageURL" alt="profile-image">
            <v-expand-transition>
            <div
              v-if="hover"
              class="d-flex transition-fast-in-fast-out black darken-2 v-avatar--reveal display-1 white--text"
              style="height: 100%;padding-top:15px;"
            >
              <div>
                Change pic<br />
                <i class="fi-camera"></i>
              </div>
            </div>
          </v-expand-transition>
          </v-img>
        </v-avatar>
        </v-hover>
        </div>
    </imageinput>
    <v-avatar v-else size="200px" v-ripple class="mb-3">
          <img v-if="!avatar" :src="user.data.picture" alt="profile-image" /> 
          <img v-else :src="avatar.imageURL" alt="profile-image" />
    </v-avatar>
    <v-slide-x-transition>
        <div v-if="avatar && saved == false" style="position:absolute; margin-left:40px;margin-top:120px">
          <button style="width:55px;" class="button primary small" @click="uploadImage" :loading="saving">Save</button>
          <button class="button alert small" @click="cancelImage" :loading="saving">Cancel</button>
        </div>
    </v-slide-x-transition>
    <div class="card-profile-stats-intro-content">
      <h3>{{user.data.lastName}} {{user.data.firstName}} <span class="yomikata">({{user.data.lastNameYomikata}} {{user.data.firstNameYomikata}})</span></h3>
      <span>Joined Rubygroupe on <strong>{{moment(user.data.entryDate).format('YYYY/MM/DD')}}</strong></span><br />
      <span>E-mail : {{user.data.email}}</span><br />
      <span>Team : {{user.data.departmentName}}</span><br />
      <span style="float:left;padding-top:8px">Phone : </span><input type="text" v-model="user.data.internalPhoneNumber" :disabled="!isEditing" :class="{view: !isEditing}" style="width:200px"></span>
    </div> <!-- /.card-profile-stats-intro-content -->
  </div> <!-- /.card-profile-stats-intro -->

  <hr />

  <div class="card-profile-stats-container">
    <div class="card-profile-stats-statistic">
      <span class="stat">{{user.data.postsCount}}</span>
      <p>posts</p>
    </div> <!-- /.card-profile-stats-statistic -->
    <div class="card-profile-stats-statistic">
      <span class="stat">{{user.data.commentsCount}}</span>
      <p>comments</p>
    </div> <!-- /.card-profile-stats-statistic -->
    <div class="card-profile-stats-statistic">
      <span class="stat">{{user.data.likesCount}}</span>
      <p>likes</p>
    </div> <!-- /.card-profile-stats-statistic -->
  </div> <!-- /.card-profile-stats-container -->

  <hr />

  <div class="card-profile-stats-aboutme">
  <p>
      <span>About me :</span>
      <span><textarea v-model="user.data.description" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:"></textarea></span>
  </p>
  </div>
  <div class="card-profile-stats-more">
    <p class="card-profile-stats-more-link"><a href="#"><i class="fa fa-angle-down" aria-hidden="true"></i></a></p>
    <div class="card-profile-stats-more-content">
        <div>Nickname :
        <input type="text" v-model="user.data.nickName" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>   
        <div>Former job title :
        <input type="text" v-model="user.data.formerJob" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>
        <div>Hobbies & Skills :
        <input type="text" v-model="user.data.hobbies" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>   
        <div>Location (area, railway line, nearest station etc) :
        <input type="text" v-model="user.data.location" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>
        <div>Birthplace :
        <input type="text" v-model="user.data.placeOfBirth" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>
        <div>Sports · Department activities during student life :
        <input type="text" v-model="user.data.studentCircles" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>
        <div>Me in one word :
        <input type="text" v-model="user.data.oneWord" :disabled="!isEditing"
           :class="{view: !isEditing}" style="width:200px">
        </div>

        <button class="button primary large" @click="isEditing = !isEditing" v-if="!isEditing && user.data.identifier == authenticatedUser.data.identifier">Edit info</button>
        <button class="button primary large" @click="save" v-else-if="isEditing && user.data.identifier == authenticatedUser.data.identifier">Save</button>
        <button class="button alert large" v-if="isEditing && user.data.identifier == authenticatedUser.data.identifier" @click="cancel">Cancel</button>
    </div> <!-- /.card-profile-stats-more-content -->
  </div> <!-- /.card-profile-stats-more -->
</div> <!-- /.card-profile-stats -->
</template>

<script>
  import moment from 'moment';
  import imageinput from '../components/global/ImageUploader';
  import {RUBYNET_CONFIG} from '../config.js';

  export default {
    components: {
      imageinput
    },
    props:['id'],
    created(){
      this.$store.dispatch('loadUser', this.id);
    },
    computed: {
      /*
        Gets the users load status
      */
      userLoadStatus(){
        return this.$store.getters.getUserLoadStatus;
      },

      /*
        Gets the user
      */
      user: {
        get: function(){
          return this.$store.getters.getUser;
        },
        set: function(value){
          this.$store.commit('setUser', value);
        }
      },

      /*
        Gets the current authentified user
      */
      authenticatedUser(){
        return this.$store.getters.getAuthenticatedUser;
      },
    },
    methods: {
      moment,
      uploadImage() {
        this.saving = true;
        var payload = {'picture' : this.avatar.formData, 'userID' : this.id};
        this.$store.dispatch('updateUserPicture', payload);  
        this.savedAvatar();
      },
      cancelImage() {
        this.saving = true;
        this.avatar = null;
        this.savedAvatar();
      },
      savedAvatar() {
        this.saving = false
        this.saved = true
      },
      save() {
        this.$store.dispatch('updateUser', this.user.data);
        Object.assign(this.userCached, this.user);
        this.isEditing = false;
      },
      cancel() {
        Object.assign(this.user, this.userCached);
        this.isEditing = false;
      }
    },
    mounted(){
      this.userCached = Object.assign({}, this.user);
    },
    data () {
      return {
        avatar: null,
        saving: false,
        saved: false,
        isEditing: false,
      }
    },
    watch:{
      avatar: {
        handler: function() {
          this.saved = false
        },
      deep: true
      }
    },
  }
</script>