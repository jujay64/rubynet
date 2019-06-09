/*
    Imports the Rubynet API URL from the config.
*/
import {RUBYNET_CONFIG} from '../config.js';

export default {
	  /*
        GET     /api/users
    */
    getUsers: function(sortBy, descending, page, usersPerPage, department){
        return axios.get(RUBYNET_CONFIG.API_URL + '/users',
        {
          params: {
            sort_by: sortBy,
            descending : descending,
            page: page,
            per_page: usersPerPage,
            department: department
          }
        });
    },

    /*
  		GET   /api/users/{userID}
	  */
	  getUser: function(userID){
  		  return axios.get(RUBYNET_CONFIG.API_URL + '/users/' + userID);
	  },

     /*
      GET   /api/user
    */
    getAuthenticatedUser: function(){
        return axios.get(RUBYNET_CONFIG.API_URL + '/user');
    },

    /*
      POST   /api/user
    */
    postAddNewUser:function(firstName, lastName, email, password, department, role, job){
        return axios.post(RUBYNET_CONFIG.API_URL + '/users',
        {
          firstName: firstName,
          lastName: lastName,
          email: email,
          password: password,
          department: department,
          role: role,
          job: job
        });
    },

    /*
      GET   /api/users/?sort_byDesc=entryData&limit=X
    */
    getNewUsers:function(){
        return axios.get(RUBYNET_CONFIG.API_URL + '/users',
        {
          params: {
            sort_by: 'entryDate',
            descending: true,
            limit: RUBYNET_CONFIG.HOME_NEWCOMERS_SHOW_LIMIT
          }
        });
    },

    /*
      GET   /api/users/?from_date_birthday=XXXX-XX-XX&to_date_birdthay=XXXX-XX-XX
    */
    getBirthdayUsers:function(){
        return axios.get(RUBYNET_CONFIG.API_URL + '/users',
        {
          params: {
            dateOfBirth: 'month',
            sort_by: 'dateOfBirth'
          }
        });
    },

    updateUserPicture:function(picture, userID){
    return axios.post(RUBYNET_CONFIG.API_URL + '/users/' + userID + '/photo', picture, {
          headers: { 'content-type': 'multipart/form-data' }
    });
    },

    updateUser:function(user){
    return axios.put(RUBYNET_CONFIG.API_URL + '/users/' + user.identifier, 
      {
          nickName: user.nickName,
          description: user.description,
          formerJob: user.formerJob,
          hobbies: user.hobbies,
          location: user.location,
          placeOfBirth: user.placeOfBirth,
          studentCircles: user.studentCircles,
          oneWord: user.oneWord,
          internalPhoneNumber: user.internalPhoneNumber
      });
    }
}