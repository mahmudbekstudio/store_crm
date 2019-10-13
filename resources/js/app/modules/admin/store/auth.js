const defaultStates = {
  isLoggedIn: false
};

export default {
  namespaced: true,

  state: Object.assign({}, defaultStates),

  mutations: {
    changeIsLoggedIn(state, val) {
      state.isLoggedIn = !!val;
    }
  },

  actions: {
    //
  },

  getters: {}
}
