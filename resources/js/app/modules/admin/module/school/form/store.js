import store from '../../../plugin/store'

store.registerModule('schoolForm', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        item: {},
        regions: [],
        errors: ''
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeItem(state, item) {
            state.item = item;
        },
        changeRegions(state, regions) {
            state.regions = regions;
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