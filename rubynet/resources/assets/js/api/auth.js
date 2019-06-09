/*
    Imports the Rubynet API URL from the config.
*/
import {RUBYNET_CONFIG} from '../config.js';

export default {
	  /*
        POST     /api/logout
    */
    postLogout: function(){
        return axios.get(RUBYNET_CONFIG.API_URL + '/auth/logout');
    },
}