import storage from '../service/Storage';
import * as constants from '../constants';

const defaultStates = {
  token: storage.get(constants.STORAGE_TOKEN_KEY) || null,
  user: storage.get(constants.STORAGE_USER_KEY) || null
};

export default {
  namespaced: true,

  state: Object.assign({}, defaultStates),

  mutations: {
    changeToken(state, val) {
      storage.set(constants.STORAGE_TOKEN_KEY, val);
      state.token = val;
    },

    changeUser(state, val) {
      storage.set(constants.STORAGE_USER_KEY, val);
      state.user = val;
    },

    clear(state) {
      storage.clear();
      state.token = null;
      state.user = null;
    }
  },

  actions: {
    //
  },

  getters: {}
}
