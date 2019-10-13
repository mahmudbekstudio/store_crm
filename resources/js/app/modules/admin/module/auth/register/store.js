import store from '../../../plugin/store'

store.registerModule('register', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        form: {
            email: '',
            password: '',
            password2: ''
        },
        errors: {
            email: '',
            password: '',
            password2: ''
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeForm(state, form) {
            state.form.email = typeof form.email !== 'undefined' ? form.email : state.form.email;
            state.form.password = typeof form.password !== 'undefined' ? form.password : state.form.password;
            state.form.password2 = typeof form.password2 !== 'undefined' ? form.password2 : state.form.password2;
        },
        changeErrors(state, errors) {
            state.errors.email = typeof errors.email !== 'undefined' ? errors.email : state.errors.email;
            state.errors.password = typeof errors.password !== 'undefined' ? errors.password : state.errors.password;
            state.errors.password2 = typeof errors.password2 !== 'undefined' ? errors.password2 : state.errors.password2;
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