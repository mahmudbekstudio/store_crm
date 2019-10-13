import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../module/routes'
import store from './store';
import viewConfig from '../config/view';
import app from '../service/App'
import auth from '../service/Auth';
import logger from '../service/Logger';

Vue.use(VueRouter);
const routersList = new VueRouter({routes});

routersList.beforeEach((to, from, next) => {
  logger.info('routersList.beforeEach', to.name, to.meta);
  store.commit('view/changeLayout', to.meta.layout || viewConfig.defaultLayout);
  store.commit('view/changePageTitle', to.meta.title || viewConfig.title);

  if(
      to.name === viewConfig.page.notFound ||
      to.name === viewConfig.page.login
  ) {
      store.commit('view/websiteInit');
      return next();
  }

  app.settings(() => {
      if(to.meta.requiresAuth) {
          auth.check(to, from, next);
      } else {
          next();
      }
  });
  next();
});

export default routersList;
