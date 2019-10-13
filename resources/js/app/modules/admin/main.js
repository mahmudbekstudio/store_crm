import Vue from 'vue';

import i18n from './plugin/i18n';
import vuetify from './plugin/vuetify';
import router from './plugin/routes';
import store from './plugin/store';

import App from './view/App';
import Logger from './service/Logger';

Vue.use(Logger);

(new Vue({
  el: '.module-admin',
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App)
}));
