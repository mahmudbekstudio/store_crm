import store from '../../../plugin/store'

store.registerModule('userForm', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        item: {},
        roles: [],
        statuses: [],
        errors: ''
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeItem(state, item) {
            state.item = item;
        },
        changeParams(state, params) {
            state.roles = params.roles;
            state.statuses = params.statuses;
        },
        changeErrors(state, errors) {
            state.errors = errors;
        },
        changeIsLoading(state, val) {
            state.isLoading = !!val;
        }
    },

    actions: {
        //
    }
});

export default store