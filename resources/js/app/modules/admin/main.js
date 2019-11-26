import Vue from 'vue';

import i18n from './plugin/i18n';
import vuetify from './plugin/vuetify';
import router from './plugin/routes';
import store from './plugin/store';

import App from './view/App';
import Logger from './service/Logger';

Vue.use(Logger);

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

(new Vue({
  el: '.module-admin',
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App)
}));
