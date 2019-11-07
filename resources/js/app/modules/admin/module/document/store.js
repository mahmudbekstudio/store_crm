import store from '../../plugin/store'

store.registerModule('document', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        params: [],
        errors: '',
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            state.list = list;
        },
        changeParams(state, list) {
            state.params = list;
        },
        changeErrors(state, errors) {
            state.errors = errors;
        },
        changeIsLoading(state, val) {
            state.isLoading = !!val;
        },
    },

    actions: {
        //
    }
});

export default store
