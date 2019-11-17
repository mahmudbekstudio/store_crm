import http from './Http';
import app from './App';
import viewConfig from '../config/view';
import store from '../plugin/store';
import { convertUtc } from '../helper';
import mainConfig from '../config/main';
import logger from './Logger';

class Auth {
  install(Vue, options) {
    Vue.prototype.$auth = this
  }

  isLogged() {
    return !!store.state.storage.token;
  }

  login(tokenObj) {
    let user = tokenObj.user;
    delete tokenObj.user;
    store.commit('storage/changeToken', tokenObj);
    store.commit('storage/changeUser', user);
    return user;
  }

  getTokenObj() {
    return store.state.storage.token;
  }

  getTokenField() {
    return mainConfig.token.field;
  }

  getAccessToken(withPrefix = true) {
    let tokenObj = this.getTokenObj();

    if(!tokenObj) return null;

    return withPrefix ? mainConfig.token.type + ' ' + tokenObj.access_token : tokenObj.access_token;
  }

  getRefreshToken(withPrefix = true) {
    let tokenObj = this.getTokenObj();

    if(!tokenObj) return null;

    return withPrefix ? mainConfig.token.type + ' ' + tokenObj.refresh_token : tokenObj.refresh_token;
  }

  isAccessTokenExpired() {
    let tokenObj = this.getTokenObj();

    if(!tokenObj) return null;

    let createdAt = new Date(convertUtc(tokenObj.created_at));
    createdAt.setMinutes(createdAt.getMinutes() + mainConfig.token.access_lifetime);

    return (new Date()).getTime() > createdAt.getTime();
  }

  isRefreshTokenExpired() {
    let tokenObj = this.getTokenObj();

    if(!tokenObj) return null;

    let createdAt = new Date(convertUtc(tokenObj.created_at));
    createdAt.setMinutes(createdAt.getMinutes() + parseInt(mainConfig.token.refresh_lifetime));

    return (new Date()).getTime() > createdAt.getTime();
  }

  logout() {
    store.commit('storage/clear');
    //storage.clear();
  }

  check(to, from, next) {
    this.checkAccess(
      () => {
        next();
      },
      () => {
        this.logout();
        next({name: viewConfig.page.login, query: { redirect: to.fullPath }});
      }
    );
  }

  checkAccess(successCallback, failCallback) {
    if(!this.isLogged() || this.isRefreshTokenExpired()) {
      failCallback();
    } else if(this.isAccessTokenExpired()) {
      app.loading(true);
      let headers = {};
      headers[this.getTokenField()] = this.getRefreshToken();

      http('auth.refresh').headers(headers).send()
        .then(response => {
          logger.info('auth.refresh', response);
          if(response.data.result) {
            app.login(response.data.token, false);
            successCallback()
          } else {
            failCallback();
          }
        })
        .catch(error => {
          logger.error('auth.refresh', error);
          failCallback();
        })
        .then(() => {
          app.loading(false);
        });
    } else {
      successCallback()
    }
  }
}

export default new Auth();
