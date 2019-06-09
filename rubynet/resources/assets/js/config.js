/*
    Defines the API route we are using.
*/
var api_url = '';
var home_newcomers_show_limit, home_birthdays_show_limit;

switch(process.env.NODE_ENV){
  case 'development':
    api_url = 'http://rubynet.test/api';
    home_newcomers_show_limit = 6;
    home_birthdays_show_limit = 6;
  break;
  case 'production': 
    api_url = 'http://hackathon.rubygroupe.jp/julien_inchausti/rubynet/api';
    home_newcomers_show_limit = 6;
    home_birthdays_show_limit = 6;
  break;
}

export const RUBYNET_CONFIG = {
  API_URL: api_url,
  HOME_NEWCOMERS_SHOW_LIMIT: home_newcomers_show_limit,
  HOME_BIRTHDAYS_SHOW_LIMIT: home_birthdays_show_limit,
}