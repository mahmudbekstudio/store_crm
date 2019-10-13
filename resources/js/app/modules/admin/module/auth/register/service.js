import http from '../../../service/Http';
import app from '../../../service/App';
import logger from '../../../service/Logger';


import api from './api';
import store from './store';
import i18n from "../../../plugin/i18n";

export default class Service {

    constructor() {
        //
    }

    submit() {
        this.loading(true);
        http(api.register)
            .callback(
                store.state.register.form.email,
                store.state.register.form.password,
                store.state.register.form.password2
            )
            .send()
            .then(response => {
                if(response.data.result) {
                    store.commit('register/changeForm', {email: '', password: ''});
                    app.successMessage(i18n.t('translations.words.success'));
                } else {
                    store.commit('register/changeErrors', {email: ' ', password: ' '});
                    let errorMsgs = [];

                    for(let val in response.data.message) {
                        if(response.data.message.hasOwnProperty(val)) {
                            errorMsgs.push(response.data.message[val]);
                        }
                    }

                    app.errorMessage(errorMsgs.join('<br />'));
                }
            })
            .catch(error => {
                logger.error('api.register', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('register/changeIsLoading', isStart);
    }
}
