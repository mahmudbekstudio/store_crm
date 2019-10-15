import store from '../../../plugin/store'

store.registerModule('categoryForm', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        item: {},
        errors: ''
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeItem(state, item) {
            state.item = item;
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