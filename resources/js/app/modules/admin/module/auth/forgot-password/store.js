import store from '../../../plugin/store'

store.registerModule('resetPassword', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        form: {
            email: ''
        },
        errors: {
            email: ''
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeForm(state, form) {
            state.form.email = typeof form.email !== 'undefined' ? form.email : state.form.email;
        },
        changeErrors(state, errors) {
            state.errors.email = typeof errors.email !== 'undefined' ? errors.email : state.errors.email;
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