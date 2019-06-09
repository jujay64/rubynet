import {RUBYNET_CONFIG} from '../config.js';

export default {
	  /*
        GET     /api/departments
    */
    getDepartments: function(){
        return axios.get(RUBYNET_CONFIG.API_URL + '/departments');
    }
}